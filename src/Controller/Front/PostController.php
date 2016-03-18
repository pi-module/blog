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
        // Find story
        $story = Pi::api('api', 'news')->getStorySingle($slug, 'slug', 'full');
        // Check status
        if (!$story || $story['status'] != 1 || $story['type'] != 'post') {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('The post not found.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Check time_publish
        if ($story['time_publish'] > time()) {
            $this->getResponse()->setStatusCode(401);
            $this->terminate(__('The post not publish.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Update Hits
        Pi::model('story', 'news')->increment('hits', array('id' => $story['id']));
        // Attached
        if ($configNews['show_attach'] && $story['attach']) {
            $attach = Pi::api('story', 'news')->AttachList($story['id']);
            $this->view()->assign('attach', $attach);
        }
        // Attribute
        if ($configNews['show_attribute'] && $story['attribute']) {
            $attribute = Pi::api('attribute', 'news')->Story($story['id'], $story['topic_main']);
            $this->view()->assign('attribute', $attribute);
        }
        // Tag
        if ($configNews['show_tag'] && Pi::service('module')->isActive('tag')) {
            $tag = Pi::service('tag')->get($module, $story['id'], '');
            $this->view()->assign('tag', $tag);
        }
        // Set vote
        if ($configNews['vote_bar'] && Pi::service('module')->isActive('vote')) {
            $vote['point'] = $story['point'];
            $vote['count'] = $story['count'];
            $vote['item'] = $story['id'];
            $vote['table'] = 'story';
            $vote['module'] = $module;
            $vote['type'] = 'star';
            $this->view()->assign('vote', $vote);
        }
        // favourite
        if ($configNews['favourite_bar'] && Pi::service('module')->isActive('favourite')) {
            $favourite['is'] = Pi::api('favourite', 'favourite')->loadFavourite($module, 'story', $story['id']);
            $favourite['item'] = $story['id'];
            $favourite['table'] = 'story';
            $favourite['module'] = $module;
            $this->view()->assign('favourite', $favourite);
        }
        // Set view
        $this->view()->headTitle($story['seo_title']);
        $this->view()->headdescription($story['seo_description'], 'set');
        $this->view()->headkeywords($story['seo_keywords'], 'set');
        $this->view()->setTemplate('post-index');
        $this->view()->assign('story', $story);
        $this->view()->assign('configNews', $configNews);
    }
}