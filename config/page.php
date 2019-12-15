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