<?php
namespace DDD\Event;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface EventListenerInterface
{
    /**
     * @param EventInterface $event
     * @return void
     */
    public function handle(EventInterface $event);
}
