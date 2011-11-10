<?php
/**
 * @package
 * @subpackage
 */
namespace Atst\Symfony\Component\EventDispatcher\Decorator;



/**
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class FireHoseTest extends \PHPUnit_Framework_TestCase
{
    private $dispatcher;
    private $innerDispatcher;

    public function setUp()
    {
        $this->innerDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->dispatcher = new FireHose($this->innerDispatcher);
    }

    public function testFireHose()
    {
        $event = new \Symfony\Component\EventDispatcher\Event;
        $obj   = $this->getMock('stdClass', array('printEvent'));

        $obj->expects($this->once())
            ->method('printEvent')
            ->with('test', $event);

        $this->dispatcher->addFireHoseListener(function($eventName, $event = null) use ($obj) {
            $obj->printEvent($eventName, $event);
        });
        $this->dispatcher->dispatch('test', $event);
    }

    public function testFireHoseEnabledDisabled()
    {
        $event = new \Symfony\Component\EventDispatcher\Event;
        $obj   = $this->getMock('stdClass', array('printEvent'));

        $obj->expects($this->never())
            ->method('printEvent');

        $this->dispatcher->addFireHoseListener(function($eventName, $event = null) use ($obj) {
            $obj->printEvent($eventName, $event);
        });
        $this->dispatcher->disableFireHose();
        $this->dispatcher->dispatch('test', $event);
    }

    public function testMultipleFireHoses()
    {
        $event = new \Symfony\Component\EventDispatcher\Event;
        $obj   = $this->getMock('stdClass', array('printEvent'));
        $obj2   = $this->getMock('stdClass', array('printEvent'));

        $obj->expects($this->once())
            ->method('printEvent')
            ->with('test', $event);

        $this->dispatcher->addFireHoseListener(function($eventName, $event = null) use ($obj) {
            $obj->printEvent($eventName, $event);
        });

        $obj2->expects($this->once())
            ->method('printEvent')
            ->with('test', $event);

        $this->dispatcher->addFireHoseListener(function($eventName, $event = null) use ($obj2) {
            $obj2->printEvent($eventName, $event);
        });

        $this->dispatcher->dispatch('test', $event);
    }

    public function testOneTimeFireHoseDisabled()
    {
        $event = new \Symfony\Component\EventDispatcher\Event;
        $obj   = $this->getMock('stdClass', array('printEvent'));

        $obj->expects($this->once())
            ->method('printEvent');

        $this->dispatcher->addFireHoseListener(function($eventName, $event = null) use ($obj) {
            $obj->printEvent($eventName, $event);
        });

        $this->dispatcher->oneTimeDisableFireHose()->dispatch('test', $event);
        $this->dispatcher->dispatch('test', $event);
    }
 
}

