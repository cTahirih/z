<?php
namespace AdminAuth2\Form\Factory;

use AdminAuth2\Form\AdminUserForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUserFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminUserForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminUserForm(
            $container->get('Zend\Db\Adapter\Adapter'),
            $container->get('AdminAuth2\Service\AdminRoleService')
        );
    }
}
