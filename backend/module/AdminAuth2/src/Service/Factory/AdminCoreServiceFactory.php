<?php
namespace AdminAuth2\Service\Factory;

use AdminAuth2\Service\AdminCoreService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminCoreServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminCoreService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminCoreService(
            $container->get('AdminAuth2\Session'),
            $container->get('Config'),
            $container,
            $container->get('EventManager')
        );
    }
}
