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