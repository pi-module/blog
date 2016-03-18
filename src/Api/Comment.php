<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Blog\Api;

use Pi;
use Pi\Application\Api\AbstractComment;

class Comment extends AbstractComment
{
    /** @var string */
    protected $module = 'blog';

    /**
     * Get target data
     *
     * @param int|int[] $item Item id(s)
     *
     * @return array
     */
    public function get($item)
    {

        $result = array();
        $items = (array)$item;

        // Set options
        $story = Pi::api('post', 'blog')->getListFromId($items);

        foreach ($items as $id) {
            $result[$id] = array(
                'id' => $story[$id]['id'],
                'title' => $story[$id]['title'],
                'url' => $story[$id]['postUrl'],
                'uid' => $story[$id]['uid'],
                'time' => $story[$id]['time_create'],
            );
        }

        if (is_scalar($item)) {
            $result = $result[$item];
        }

        return $result;
    }

    /**
     * Locate source id via route
     *
     * @param RouteMatch|array $params
     *
     * @return mixed|bool
     */
    public function locate($params = null)
    {
        if (null == $params) {
            $params = Pi::engine()->application()->getRouteMatch();
        }
        if ($params instanceof RouteMatch) {
            $params = $params->getParams();
        }
        if ('blog' == $params['module']
            && !empty($params['slug'])
        ) {
            $post = Pi::api('post', 'blog')->getPost($params['slug'], 'slug');
            $item = $post['id'];
        } else {
            $item = false;
        }
        return $item;
    }
}
