<?php
namespace DDD\Event;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait RecordsEventsTrait
{
    /**
     * @var EventInterface[]
     */
    protected $events = [];
    
    /**
     * @param EventInterface $event
     * @return self
     */
    public function record(EventInterface $event)
    {
        $this->events[] = $event;
        return $this;
    }
    
    
    /**
     * @return EventInterface[]
     */
    public function releaseEvents()
    {
        $events       = $this->events;
        $this->events = [];
        
        return $events;
    }
}
