<?php
namespace DDD\Controller\Plugin;

use DDD\Event\EventDispatcher;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
/**
 * Returns a DDD\Event\Dispatcher instance from the Service Manager.
 *
 * @see AbstractPlugin
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class EventDispatcherPlugin extends AbstractPlugin
{
    /**
     * @param EventDispatcher $dispatcher
     * @return void
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    
    /**
     * @return EventDispatcher
     */
    public function __invoke()
    {
        return $this->eventDispatcher;
    }
}
