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
    public static function recentPost($options = [], $module = null)
    {
        // Set options
        $block = [];
        $block = array_merge($block, $options);

        // Set info
        $where = [
            'status' => 1,
            'type'   => 'post',
        ];
        $table = 'story';
        $order = ['time_publish DESC', 'id DESC'];

        // Set block array
        $posts = Pi::api('post', 'blog')->getPostList($where, $order, '', $block['number'], 'full', $table);

        foreach ($posts as $post) {
            $block['resources'][$post['id']] = $post;
            if (!empty($block['text_limit']) && $block['text_limit'] > 0) {
                $block['resources'][$post['id']]['text_summary'] = mb_substr(
                        strip_tags($block['resources'][$post['id']]['text_summary']), 0, $block['text_limit'], 'utf-8'
                    ) . "...";
            }
        }

        $block['morelink'] = Pi::url(
            Pi::service('url')->assemble(
                'blog', [
                'module' => $module,
                'controller' => 'index',
                'action' => 'index',
            ]
            )
        );

        return $block;
    }
}