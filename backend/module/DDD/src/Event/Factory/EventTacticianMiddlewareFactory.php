<?php
namespace DDD\Event\Factory;

use DDD\Event\EventTacticianMiddleware;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package DDD
 * @author Jaime G. Wong <j@jgwong.org>
 */
class EventTacticianMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return EventTacticianMiddleware
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EventTacticianMiddleware(
            $container->get('DDD\Event\EventRecorder'),
            $container->get('DDD\Event\EventDispatcher')
        );
    }
}
