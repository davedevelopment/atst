<?php
/**
 * @package
 * @subpackage
 */
namespace Atst\Symfony\Component\EventDispatcher;

use Symfony\Component\EventDispatcher\Event as SyEvent;

/**
 * Includes a timestamp of when the event was created
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class Event extends SyEvent
{
    /**
     * @var int
     */
    public $created = null;

    public function __construct() 
    {
        $this->created = new \DateTime();
    }
}
