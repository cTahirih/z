<?php
namespace AdminAuth2\Controller\Factory;

use AdminAuth2\Controller\DashboardController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DashboardControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return DashboardController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DashboardController(
            $container->get('AdminAuth2\Service\AdminCoreService')
        );
    }
}
