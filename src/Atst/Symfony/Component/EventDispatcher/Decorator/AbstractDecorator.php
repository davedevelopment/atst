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
 * Abstract Decorator
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class AbstractDecorator implements EventDispatcherInterface 
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param bool                     $autoRegister
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @see EventDispatcherInterface::addListener
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        return $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    /**
      * @see EventDispatcherInterface::removeListener
      */
    public function removeListener($eventName, $listener)
    {
        return $this->dispatcher->removeListener($eventName, $listener);
    }

    /**
     * @see EventDispatcherInterface::dispatch
     */
    public function dispatch($eventName, Event $event = null)
    {
        return $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * @see EventDispatcherInterface::getListeners
     */
    public function getListeners($eventName = null)
    {
        return $this->dispatcher->getListeners($eventName);
    }

    /**
     * @see EventDispatcherInterface::hasListeners
     */
    public function hasListeners($eventName = null)
    {
        return $this->dispatcher->hasListeners($eventName);
    }

    /**
     * @see EventDispatcherInterface::addSubscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->addSubscriber($subscriber);
    }

    /**
     * @see EventDispatcherInterface::removeSubscriber
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->removeSubscriber($subscriber);
    }
    
}
