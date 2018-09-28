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
return array(
    'blog' => array(
        'title' => _a('Blog comments'),
        'icon' => 'icon-post',
        'callback' => 'Module\Blog\Api\Comment',
        'locator' => 'Module\Blog\Api\Comment',
    ),
);