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

namespace Module\Blog\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Install as BasicInstall;
use Zend\EventManager\Event;

class Install extends BasicInstall
{
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('install.pre', [$this, 'checkConflicts'], 1000);
        parent::attachDefaultListeners();
        return $this;
    }

    /**
     * Check other modules in conflict
     *
     * @param Event $e
     *
     * @return bool
     */
    public function checkConflicts(Event $e)
    {
        $modules = Pi::registry('module')->read();
        if (!isset($modules['news'])) {
            $this->setResult(
                'event', [
                'status'  => false,
                'message' => 'install news module first',
            ]
            );

            return false;
        }
        return true;
    }
}