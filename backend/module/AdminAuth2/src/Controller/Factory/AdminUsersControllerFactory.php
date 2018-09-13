<?php
namespace AdminAuth2\Controller\Factory;

use AdminAuth2\Controller\AdminUsersController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUsersControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminUsersController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminUsersController(
            $container->get('AdminAuth2\Service\AdminCoreService'),
            $container->get('AdminAuth2\Provider\AdminUserProvider')
        );
    }
}
