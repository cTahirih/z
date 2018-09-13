<?php
namespace DDD\Event;

use RuntimeException;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
class EventDispatcher
{
    /**
     * @var array
     */
    protected $listeners = [];
    
    
    /**
     * @param string $name
     * @param EventListenerInterface|EventListenerInterface[] $listener
     * @return self
     */
    public function addListener($name, $listeners)
    {
        if (!is_string($name)) {
            throw new RuntimeException('Invalid type; name should be a string.');
        }
        
        if ($listeners instanceof EventListenerInterface) {
            $listeners = [$listeners];
        }
        
        foreach ($listeners as $listener) {
            if (!$listener instanceof EventListenerInterface) {
                throw new RuntimeException('Invalid type; listener should be an instance of DDD\Event\EventListenerInterface.');
            }
            
            $this->listeners[$name][] = $listener;
        }
        return $this;
    }
    
    
    /**
     * @param string $name
     * @return EventListenerInterface[]
     */
    public function getListenersFor($name)
    {
        $listeners = $this->listeners;
        
        if (array_key_exists($name, $listeners)) {
            return $listeners[$name];
        }
        
        return [];
    }
    
    
    /**
     * @param EventInterface $event
     * @return void
     */
    public function triggerListenersForEvent(EventInterface $event)
    {
        $name = $event->getName();
        
        foreach ($this->getListenersFor($name) as $listener) {
            $listener->handle($event);
        }
    }
    
    
    /**
     * Dispatches all registered Listeners for the given object that
     * implements RecordsEventsInterface.
     *
     * @param RecordsEvents
     * @return void
     */
    public function dispatch(RecordsEventsInterface $eventRecorder)
    {
        foreach ($eventRecorder->releaseEvents() as $event) {
            $this->triggerListenersForEvent($event);
        }
    }
}
