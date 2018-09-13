<?php
namespace AdminAuth2\Service\Factory;

use AdminAuth2\Service\AdminRoleService;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminRoleServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return AdminRoleService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        
        return new AdminRoleService(
            $entityManager,
            new DoctrineHydrator($entityManager),
            $container->get('AdminAuth2\Service\ResourceService')
        );
    }
}
