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

namespace Module\Blog\Api;

use Pi;
use Pi\Application\Api\AbstractBreadcrumbs;

class Breadcrumbs extends AbstractBreadcrumbs
{
    /**
     * {@inheritDoc}
     */
    public function load()
    {
        // Get params
        $params = Pi::service('url')->getRouteMatch()->getParams();
        // Set module link
        $moduleData = Pi::registry('module')->read($this->getModule());
        // Make tree
        if (!empty($params['controller']) && $params['controller'] != 'index') {
            // Set index
            $result = [
                [
                    'label' => $moduleData['title'],
                    'href'  => Pi::url(
                        Pi::service('url')->assemble(
                            'blog', [
                            'module' => $this->getModule(),
                        ]
                        )
                    ),
                ],
            ];
            // Set
            switch ($params['controller']) {
                case 'post':
                    $post     = Pi::api('api', 'news')->getStorySingle($params['slug'], 'slug', 'light');
                    $result[] = [
                        'label' => $post['title'],
                    ];
                    break;
            }
        } else {
            $result = [
                [
                    'label' => $moduleData['title'],
                ],
            ];
        }
        return $result;
    }
}