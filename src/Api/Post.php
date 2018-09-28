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
namespace Module\Blog\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('post', 'blog')->getPost($parameter, $field, $type)
 * Pi::api('post', 'blog')->getPostList($where, $order, $offset, $limit, $type, $table);
 * Pi::api('post', 'blog')->getListFromId($id);
 */
class Post extends AbstractApi
{
    public function getPost($parameter, $field = 'id', $type = 'full')
    {
        $post = Pi::api('api', 'news')->getStorySingle($parameter, $field, $type);
        return $post;
    }

    public function getPostList($where, $order, $offset, $limit, $type, $table)
    {
        $postList = array();
        $list = Pi::api('api', 'news')->getStoryList($where, $order, $offset, $limit, $type, $table);
        foreach ($list as $single) {
            $postList[$single['id']] = $single;
            $postList[$single['id']]['postUrl'] = Pi::url(Pi::service('url')->assemble('blog', array(
                'module' => 'blog',
                'controller' => 'post',
                'slug' => $single['slug'],
            )));
        }

        return $postList;
    }

    public function getListFromId($id)
    {
        $list = array();
        $where = array('id' => $id, 'status' => 1);
        $postList = Pi::api('api', 'news')->getStoryList($where, '', '', '', 'light', 'story');
        foreach ($postList as $post) {
            $list[$post['id']] = $post;
            $list[$post['id']]['postUrl'] = Pi::url(Pi::service('url')->assemble('blog', array(
                'module' => $this->getModule(),
                'controller' => 'post',
                'slug' => $post['slug'],
            )));
        }
        return $list;
    }
}