<?php
namespace DDD\Command;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface CommandHandlerInterface
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command);
}
