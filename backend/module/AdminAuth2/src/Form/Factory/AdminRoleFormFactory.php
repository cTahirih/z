<?php
namespace AdminAuth2\Form\Factory;

use AdminAuth2\Form\AdminRoleForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminRoleFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminRoleForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminRoleForm(
            $container->get('AdminAuth2\Service\ResourceService')
        );
    }
}
