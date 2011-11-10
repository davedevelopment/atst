<?php
/**
 * @package
 * @subpackage
 */
namespace Atst\Symfony\Component\EventDispatcher\Decorator;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * A decorator allowing consumers to add a 'firehose' listener, i.e. a listener
 * that gets all events
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class FireHose extends AbstractDecorator
{
    /**
     * @var array
     */
    protected $fireHoseListeners = array();

    /**
     * @var bool
     */
    protected $fireHoseEnabled = true;

    /**
     * @var bool
     */
    protected $oneTimeDisableFireHose = false;

    /**
     * Add a fire hose listener
     *
     * @param callable $listener
     */
    public function addFireHoseListener($listener)
    {
        if (!is_callable($listener)) { 
            throw new \InvalidArgumentException('Expected callable argument');
        }

        $this->fireHoseListeners[] = $listener;
    }

    /**
     * Remove a fire hose listener
     *
     * @param callable $listener
     */
    public function removeFireHoseListener($listener)
    {
        $key = array_search($listener, $this->fireHoseListeners);
        if (false !== $key) {
            unset($this->fireHoseListeners[$key]);
        }
    }

    /**
     * @see EventDispatcherInterface::dispatch
     *
     * @api
     */
    public function dispatch($eventName, Event $event = null)
    {
        if ($this->isFireHoseEnabled() && !$this->oneTimeDisableFireHose) {
            foreach ($this->fireHoseListeners as $listener) {
                call_user_func($listener, $eventName, $event);
            }
        }
        $this->oneTimeDisableFireHose = false;
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * Enable the firehose
     *
     */
    public function enableFireHose() 
    {
        $this->fireHoseEnabled = true;
    }

    /**
     * Disable the firehose
     */
    public function disableFireHose() 
    {
        $this->fireHoseEnabled = false;
    }

    /**
     * Disable the firehose for the next dispatch
     *
     */
    public function oneTimeDisableFireHose()
    {
        $this->oneTimeDisableFireHose = true;
        return $this;
    }

    /**
     * Is the firehose enabled?
     *
     * @return bool
     */
    public function isFireHoseEnabled() 
    {
        return $this->fireHoseEnabled;
    }
}
