<?php
namespace AdminAuth2\Provider\Factory;

use AdminAuth2\Provider\AdminUserProvider;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUserProviderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminUserProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminUserProvider(
            $container->get('AdminAuth2\Provider\AdminUserResourceProvider'),
            $container->get('Doctrine\ORM\EntityManager'),
            $container->get('AdminAuth2\Form\AdminUserForm')
        );
    }
}
