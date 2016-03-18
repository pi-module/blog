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
return array(
    'blog' => array(
        'title' => _a('Blog comments'),
        'icon' => 'icon-post',
        'callback' => 'Module\Blog\Api\Comment',
        'locator' => 'Module\Blog\Api\Comment',
    ),
);