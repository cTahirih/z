<?php
namespace Base;

use Interop\Container\ContainerInterface;

/**
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface SkelsusCommandProviderInterface
{
    /**
     * Should return an array of Symfony\Component\Console\Command\Command
     * objects.
     *
     * @param ContainerInterface $container
     * @return void
     */
    public function getSkelsusCommands(ContainerInterface $container);
}
