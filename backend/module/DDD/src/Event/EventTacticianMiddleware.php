<?php
namespace DDD\Event;

use League\Tactician\Middleware;

/**
 * A Tactician Middleware for the Event Dispatcher.
 *
 * @see Middleware
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
class EventTacticianMiddleWare implements Middleware
{
    /**
     * @var EventRecorderInterface
     */
    protected $eventRecorder;
    
    
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;
    
    
    /**
     * @param RecordsEventsInterface $eventRecorder
     * @param EventDispatcher $eventDispatcher
     * @return void
     */
    public function __construct(RecordsEventsInterface $eventRecorder, EventDispatcher $eventDispatcher)
    {
        $this->eventRecorder   = $eventRecorder;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    
    /**
     * @param mixed $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $return = $next($command);
        $this->eventDispatcher->dispatch($this->eventRecorder);
        
        return $return;
    }
}
