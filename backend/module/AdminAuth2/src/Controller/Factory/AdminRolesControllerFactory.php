<?php
namespace AdminAuth2\Controller\Factory;

use AdminAuth2\Controller\AdminRolesController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminRolesControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminRolesController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminRolesController(
            $container->get('AdminAuth2\Service\AdminCoreService'),
            $container->get('AdminAuth2\Provider\AdminRoleProvider')
        );
    }
}
