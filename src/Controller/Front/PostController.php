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

class PostController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $slug = $this->params('slug');
        $module = $this->params('module');
        // Get Module Config
        $configNews = Pi::service('registry')->config->read('news');
        // Find spost
        $post = Pi::api('post', 'blog')->getPost($slug, 'slug', 'full');
        // Check status
        if (!$post || $post['status'] != 1 || $post['type'] != 'post') {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('The post not found.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Check time_publish
        if ($post['time_publish'] > time()) {
            $this->getResponse()->setStatusCode(401);
            $this->terminate(__('The post not publish.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Update Hits
        Pi::model('story', 'news')->increment('hits', array('id' => $post['id']));
        // Attached
        if ($configNews['show_attach'] && $post['attach']) {
            $attach = Pi::api('story', 'news')->AttachList($post['id']);
            $this->view()->assign('attach', $attach);
        }
        // Attribute
        if ($configNews['show_attribute'] && $post['attribute']) {
            $attribute = Pi::api('attribute', 'news')->Story($post['id'], $post['topic_main']);
            $this->view()->assign('attribute', $attribute);
        }
        // Tag
        if ($configNews['show_tag'] && Pi::service('module')->isActive('tag')) {
            $tag = Pi::service('tag')->get($module, $post['id'], '');
            $this->view()->assign('tag', $tag);
        }
        // Set vote
        if ($configNews['vote_bar'] && Pi::service('module')->isActive('vote')) {
            $vote['point'] = $post['point'];
            $vote['count'] = $post['count'];
            $vote['item'] = $post['id'];
            $vote['table'] = 'story';
            $vote['module'] = $module;
            $vote['type'] = 'star';
            $this->view()->assign('vote', $vote);
        }
        // favourite
        if ($configNews['favourite_bar'] && Pi::service('module')->isActive('favourite')) {
            $favourite['is'] = Pi::api('favourite', 'favourite')->loadFavourite($module, 'story', $post['id']);
            $favourite['item'] = $post['id'];
            $favourite['table'] = 'story';
            $favourite['module'] = $module;
            $this->view()->assign('favourite', $favourite);
        }
        // Set view
        $this->view()->headTitle($post['seo_title']);
        $this->view()->headdescription($post['seo_description'], 'set');
        $this->view()->headkeywords($post['seo_keywords'], 'set');
        $this->view()->setTemplate('post-detail');
        $this->view()->assign('post', $post);
        $this->view()->assign('configNews', $configNews);
    }
}