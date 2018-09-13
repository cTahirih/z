<?php
namespace AdminAuth2\Controller\Factory;

use AdminAuth2\Controller\LoginController;
use AdminAuth2\Form\LoginForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\Container;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return LoginController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LoginController(
            $container->get('AdminAuth2\Service\AdminCoreService'),
            $container->get('AdminAuth2\Service\AdminUserService'),
            $container->get('AdminAuth2\Service\AdminRoleService'),
            new LoginForm()
        );
    }
}
