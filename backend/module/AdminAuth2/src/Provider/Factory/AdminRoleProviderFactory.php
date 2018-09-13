<?php
namespace AdminAuth2\Provider\Factory;

use AdminAuth2\Provider\AdminRoleProvider;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminRoleProviderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string requestedName
     * @param array $options
     * @return AdminRoleProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminRoleProvider(
            $container->get('AdminAuth2\Provider\AdminRoleResourceProvider'),
            $container->get('Doctrine\ORM\EntityManager'),
            $container->get('AdminAuth2\Form\AdminRoleForm'),
            $container->get('AdminAuth2\Service\ResourceService')
        );
    }
}
