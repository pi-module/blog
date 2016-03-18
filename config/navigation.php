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
    // Admin section
    'admin' => array(
        'index' => array(
            'label' => _a('Blog'),
            'permission' => array(
                'resource' => 'index',
            ),
            'route' => 'admin',
            'module' => 'blog',
            'controller' => 'index',
            'action' => 'index',
        ),
    ),
);