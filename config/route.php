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
    // route name
    'blog' => array(
        'name' => 'blog',
        'type' => 'Module\Blog\Route\Blog',
        'options' => array(
            'route' => '/blog',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'index'
            )
        ),
    )
);