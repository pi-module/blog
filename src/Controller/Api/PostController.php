<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\Blog\Controller\Api;

use Pi;
use Pi\Mvc\Controller\ActionController;

class PostController extends ActionController
{
    public function listAction()
    {
        // Set default result
        $result = [
            'result' => false,
            'data'   => [],
            'error'  => [
                'code'        => 1,
                'message'     => __('Nothing selected'),
                'messageFlag' => false,
            ],
        ];

        // Get config
        $config = Pi::service('registry')->config->read('tools');

        // Get info from url
        $token = $this->params('token');

        // Check token
        $check = Pi::api('token', 'tools')->check($token);
        if ($check['status'] == 1) {

            // Get page
            $page   = $this->params('page', 1);
            $limit   = $this->params('limit');

            // Set info
            $where  = [
                'status' => 1,
                'type'   => 'post',
            ];
            $order  = ['time_publish DESC', 'id DESC'];
            $limit  = !empty($limit) ? intval($limit) : intval($config['view_perpage']);
            $offset = (int)($page - 1) * $limit;

            // Get list of post
            $postList = Pi::api('post', 'blog')->getPostList($where, $order, $offset, $limit, 'json', 'story');

            // Get count
            $count = Pi::api('api', 'news')->getStoryCount($where, 'story');

            // Set default result
            $result = [
                'result' => true,
                'data'   => [
                    'posts'   => array_values($postList),
                    'paginator' => [
                        'count' => $count,
                        'limit' => $limit,
                        'page'  => intval($page),
                    ],
                    'condition' => [
                        'title' => __('List of blog posts'),
                    ],
                ],
                'error'  => [
                    'code'    => 0,
                    'message' => '',
                ],
            ];
        } else {
            // Set error
            $result['error'] = [
                'code'    => $check['code'],
                'message' => $check['message'],
            ];
        }

        return $result;
    }

    public function singleAction()
    {
        // Set default result
        $result = [
            'result' => false,
            'data'   => [],
            'error'  => [
                'code'        => 1,
                'message'     => __('Nothing selected'),
                'messageFlag' => false,
            ],
        ];

        // Get info from url
        $token = $this->params('token');
        $postId   = $this->params('post_id');

        // Check token
        $check = Pi::api('token', 'tools')->check($token);
        if ($check['status'] == 1) {

            // Check id
            if (intval($postId) > 0) {

                // Find post
                $post = Pi::api('post', 'blog')->getPost($postId, 'id', 'json');

                // Check status
                if (!$post || $post['status'] != 1 || $post['type'] != 'post') {
                    // Set error
                    $result['error'] = [
                        'code'    => 4,
                        'message' => __('The post not found.'),
                    ];
                    return $result;
                }

                // Check time_publish
                if ($post['time_publish'] > time()) {
                    // Set error
                    $result['error'] = [
                        'code'    => 5,
                        'message' => __('The post not publish.'),
                    ];
                    return $result;
                }

                // Update Hits
                Pi::model('story', 'news')->increment('hits', ['id' => $post['id']]);

                // Set default result
                $result = [
                    'result' => true,
                    'data'   => [
                        $post
                    ],
                    'error'  => [
                        'code'    => 0,
                        'message' => '',
                    ],
                ];
            } else {
                // Set error
                $result['error'] = [
                    'code'    => 3,
                    'message' => __('Id not selected'),
                ];
            }
        } else {
            // Set error
            $result['error'] = [
                'code'    => $check['code'],
                'message' => $check['message'],
            ];
        }

        return $result;
    }
}
