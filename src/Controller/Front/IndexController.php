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
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        $page   = $this->params('page', 1);
        // Get config
        $config = Pi::service('registry')->config->read($module);
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
        // Set view
        $this->view()->setTemplate('post-list');
        $this->view()->assign('postList', $postList);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('title', __('Blog post list'));
    }
}