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
namespace Module\Blog\Block;

use Pi;
use Module\Guide\Form\SearchLocationForm;

class Block
{
    public static function recentPost($options = array(), $module = null)
    {
        // Set options
        $block = array();
        $block = array_merge($block, $options);

        $where = array(
            'status' => 1,
            'type' => 'post',
        );

        /* if (isset($block['topic-id']) && !empty($block['topic-id']) && !in_array(0, $block['topic-id'])) {
            $where['topic'] = $block['topic-id'];
            $table = 'link';
        } else {
            $table = 'story';
        } */
        $table = 'story';

        $order = array('time_publish DESC', 'id DESC');

        // Set block array
        $block['resources'] = Pi::api('post', 'blog')->getPostList($where, $order, '', $block['number'], 'full', $table);
        $block['morelink'] = Pi::url(Pi::service('url')->assemble('blog', array(
            'module' => $module,
            'controller' => 'index',
            'action' => 'index',
        )));

        return $block;
    }
}