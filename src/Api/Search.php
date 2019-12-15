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

namespace Module\Blog\Api;

use Pi;
use Pi\Search\AbstractSearch;

class Search extends AbstractSearch
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'story';

    /**
     * {@inheritDoc}
     */
    protected $searchIn
        = [
            'title',
            'text_summary',
            'text_description',
        ];

    /**
     * {@inheritDoc}
     */
    protected $meta
        = [
            'id'           => 'id',
            'title'        => 'title',
            'text_summary' => 'content',
            'time_create'  => 'time',
            'slug'         => 'slug',
            'image'        => 'image',
            'path'         => 'path',
        ];

    /**
     * {@inheritDoc}
     */
    protected $condition
        = [
            'status' => 1,
            'type'   => 'post',
        ];

    /**
     * {@inheritDoc}
     */
    protected function getModel($table = '')
    {
        $model = Pi::model('story', 'news');

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    protected function buildUrl(array $item, $table = '')
    {
        $link = Pi::url(
            Pi::service('url')->assemble(
                'blog', [
                'module'     => $this->getModule(),
                'controller' => 'post',
                'slug'       => $item['slug'],
            ]
            )
        );

        return $link;
    }

    /**
     * {@inheritDoc}
     */
    protected function buildImage(array $item, $table = '')
    {
        // Get config
        $config = Pi::service('registry')->config->read('news');

        if (isset($item['main_image']) && !empty($item['main_image'])) {
            return (string)Pi::api('doc', 'media')->getSingleLinkUrl($item['main_image'])->setConfigModule('news')->thumb('medium');
        }

        $image = '';
        if (isset($item['image']) && !empty($item['image'])) {
            $image = Pi::url(
                sprintf(
                    'upload/%s/thumb/%s/%s',
                    $config['image_path'],
                    $item['path'],
                    $item['image']
                )
            );
        }

        return $image;
    }
}