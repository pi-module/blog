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

namespace Module\Blog\Controller\Front;

use Pi;
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;

class TagController extends ActionController
{
    public function termAction()
    {
        // Get info from url
        $module = $this->params('module');
        $page   = $this->params('page', 1);
        $slug   = $this->params('slug');

        // Get config
        $config = Pi::service('registry')->config->read($module);

        // Check tag
        if (!Pi::service('module')->isActive('tag')) {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('Tag module not installed.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }

        // Check slug
        if (!isset($slug) || empty($slug)) {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('The tag not set.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }

        // Get id from tag module
        $tagId = [];
        $tags  = Pi::service('tag')->getList($slug, $module);
        foreach ($tags as $tag) {
            $tagId[] = $tag['item'];
        }

        // Check slug
        if (empty($tagId)) {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('The tag not found.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
        }

        // Set info
        $where  = [
            'status' => 1,
            'type'   => 'post',
        ];
        $offset = (int)($page - 1) * $config['view_perpage'];
        $order  = ['time_publish DESC', 'id DESC'];
        $limit  = intval($config['view_perpage']);

        // Get list of post
        $postList = Pi::api('post', 'blog')->getPostList($where, $order, $offset, $limit, 'full', 'story');

        // Set template
        $template = [
            'module'     => 'blog',
            'controller' => 'index',
            'action'     => 'index',
        ];

        // Get paginator
        $paginator = Pi::api('api', 'news')->getStoryPaginator($template, $where, $page, $limit, 'story');

        // Set header and title
        $title = sprintf(__('All blog posts from %s'), $slug);

        // Set seo_keywords
        $filter = new Filter\HeadKeywords;
        $filter->setOptions(
            [
                'force_replace_space' => true,
            ]
        );
        $seoKeywords = $filter($title);

        // Set view
        $this->view()->headTitle($title);
        $this->view()->headDescription($title, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('post-list');
        $this->view()->assign('postList', $postList);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('title', $title);
        $this->view()->assign('config', $config);
    }

    public function listAction()
    {
        // Get info from url
        $module  = $this->params('module');
        $tagList = [];
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Check deactivate view
        if ($config['admin_deactivate_view']) {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('Page not found.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Check tag module install or not
        if (Pi::service('module')->isActive('tag')) {
            $where  = ['module' => $module];
            $order  = ['count DESC', 'id DESC'];
            $select = Pi::model('stats', 'tag')->select()->where($where)->order($order);
            $rowset = Pi::model('stats', 'tag')->selectWith($select);
            foreach ($rowset as $row) {
                $tag                       = Pi::model('tag', 'tag')->find($row->term, 'term');
                $tagList[$row->id]         = $row->toArray();
                $tagList[$row->id]['term'] = $tag['term'];
                $tagList[$row->id]['url']  = Pi::url(
                    $this->url(
                        '', [
                            'controller' => 'tag',
                            'action'     => 'term',
                            'slug'       => urlencode($tag['term']),
                        ]
                    )
                );
            }
        }
        // Set header and title
        $title = __('List of all used tags');
        // Set seo_keywords
        $filter = new Filter\HeadKeywords;
        $filter->setOptions(
            [
                'force_replace_space' => true,
            ]
        );
        $seoKeywords = $filter($title);

        // Save statistics
        if (Pi::service('module')->isActive('statistics')) {
            Pi::api('log', 'statistics')->save('news', 'tagList');
        }

        // Set view
        $this->view()->headTitle($title);
        $this->view()->headDescription($title, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('tag-list');
        $this->view()->assign('title', $title);
        $this->view()->assign('tagList', $tagList);
    }
}