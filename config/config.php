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
    'category' => [
        [
            'title' => _a('Admin'),
            'name'  => 'admin',
        ],
        [
            'title' => _a('View'),
            'name'  => 'view',
        ],
        [
            'title' => _a('Social'),
            'name'  => 'social',
        ],
    ],
    'item'     => [
        // Admin
        'admin_perpage'          => [
            'category'    => 'admin',
            'title'       => _a('Perpage'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 10,
        ],

        // View
        'view_perpage'           => [
            'category'    => 'view',
            'title'       => _a('Perpage'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 10,
        ],
        'view_template'          => [
            'title'       => _a('View template'),
            'description' => '',
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'list' => _a('List'),
                        'box'  => _a('Box'),
                    ],
                ],
            ],
            'filter'      => 'text',
            'value'       => 'list',
            'category'    => 'view',
        ],
        'text_limit'     => [
            'title'       => _a('Text width limit'),
            'description' => _a('Set 0 for no limit'),
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 0,
        ],

        // Social
        'social_sharing'         => [
            'title'       => _t('Social sharing items'),
            'description' => '',
            'edit'        => [
                'type'    => 'multi_checkbox',
                'options' => [
                    'options' => Pi::service('social_sharing')->getList(),
                ],
            ],
            'filter'      => 'array',
            'category'    => 'social',
        ],

        // head_meta
        'text_description_index' => [
            'category'    => 'head_meta',
            'title'       => _a('Description for index page'),
            'description' => '',
            'edit'        => 'textarea',
            'filter'      => 'string',
            'value'       => '',
        ],
    ],
];
