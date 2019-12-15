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
    // Admin section
    'admin' => [
        'index' => [
            'label'      => _a('Blog'),
            'permission' => [
                'resource' => 'index',
            ],
            'route'      => 'admin',
            'module'     => 'blog',
            'controller' => 'index',
            'action'     => 'index',
        ],
    ],
];