<?php
namespace DDD\Event;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface RecordsEventsInterface
{
    /**
     * @param EventInterface $event
     * @return self
     */
    public function record(EventInterface $event);
    
    /**
     * @return EventInterface[]
     */
    public function releaseEvents();
}
