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
return [
    // Front section
    'front' => [
        [
            'title'      => _a('Index page'),
            'controller' => 'index',
            'permission' => 'public',
            'block'      => 1,
        ],
        [
            'title'      => _a('Post'),
            'controller' => 'post',
            'permission' => 'public',
            'block'      => 1,
        ],
    ],
    // Admin section
    'admin' => [
        [
            'title'      => _a('Blog'),
            'controller' => 'index',
            'permission' => 'index',
        ],
    ],
];