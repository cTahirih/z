<?php
namespace DDD\Controller\Plugin\Factory;

use DDD\Controller\Plugin\EventDispatcherPlugin;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
class EventDispatcherPluginFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return EventDispatcherPlugin
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EventDispatcherPlugin(
            $container->get('DDD\Event\EventDispatcher')
        );
    }
}
