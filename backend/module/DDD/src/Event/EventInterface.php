<?php
namespace DDD\Event;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName();
}
