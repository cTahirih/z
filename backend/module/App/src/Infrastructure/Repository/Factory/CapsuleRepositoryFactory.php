<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\CapsuleRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CapsuleRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return CapsuleRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CapsuleRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
