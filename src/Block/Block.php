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

        // Set info
        $where = array(
            'status' => 1,
            'type' => 'post',
        );
        $table = 'story';
        $order = array('time_publish DESC', 'id DESC');

        // Set block array
        $posts = Pi::api('post', 'blog')->getPostList($where, $order, '', $block['number'], 'full', $table);

        foreach ($posts as $post) {
            $block['resources'][$post['id']] = $post;
            if (!empty($block['textlimit']) && $block['textlimit'] > 0) {
                $block['resources'][$post['id']]['text_summary'] = mb_substr(strip_tags($block['resources'][$post['id']]['text_summary']), 0, $block['textlimit'], 'utf-8' ) . "...";
            }
        }

        $block['morelink'] = Pi::url(Pi::service('url')->assemble('blog', array(
            'module' => $module,
            'controller' => 'index',
            'action' => 'index',
        )));

        return $block;
    }
}