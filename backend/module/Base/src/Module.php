<?php
namespace Base;

use Base\Skelsus\Console\Command\ConsoleCommand;
use Base\Skelsus\Console\Command\DatabaseCommand;
use Interop\Container\ContainerInterface;

/**
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Module implements SkelsusCommandProviderInterface
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    
    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function getSkelsusCommands(ContainerInterface $container)
    {
        return [
            new ConsoleCommand(),
            new DatabaseCommand(),
        ];
    }
}
