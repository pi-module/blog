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
    'recent-post' => [
        'title'       => _a('Recent posts'),
        'description' => _a('Recent posts list'),
        'render'      => ['block', 'recentPost'],
        'template'    => 'recent-post',
        'config'      => [
            'number'        => [
                'title'       => _a('Number'),
                'description' => '',
                'edit'        => 'text',
                'filter'      => 'number_int',
                'value'       => 5,
            ],
            'view_summary'  => [
                'title'       => _a('Show summary'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
            'text_limit'     => [
                'title'       => _a('Text width limit'),
                'description' => _a('Set 0 for no limit'),
                'edit'        => 'text',
                'filter'      => 'number_int',
                'value'       => 0,
            ],
            'view_time'     => [
                'title'       => _a('Show time'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
            'view_topic'    => [
                'title'       => _a('Show topic'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
            'view_hits'     => [
                'title'       => _a('Show hits'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
            'view_image'    => [
                'title'       => _a('Show image'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
            'view_more_link' => [
                'title'       => _a('Show more link'),
                'description' => '',
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 0,
            ],
            'block_effect'  => [
                'title'       => _a('Use block effects'),
                'description' => _a('Use block effects or set custom effect on theme'),
                'edit'        => 'checkbox',
                'filter'      => 'number_int',
                'value'       => 1,
            ],
        ],
    ],
];