<?php
namespace DDD\Command;

use DDD\Event\EventInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait RecordEventTrait
{
    /**
     * Convenience method to record an Event to an injected EventRecorder in
     * a Command Handler.
     * 
     * @param EventInterface $event
     * @return self
     */
    public function record(EventInterface $event)
    {
        $this->eventRecorder->record($event);
        return $this;
    }
}
