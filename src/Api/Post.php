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
use Pi\Application\Api\AbstractApi;

/*
  * Pi::api('post', 'blog')->getPostList($where, $order, $offset, $limit, $type, $table);
 */
class Post extends AbstractApi
{
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
}