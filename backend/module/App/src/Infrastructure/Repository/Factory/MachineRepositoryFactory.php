<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\MachineRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return MachineRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MachineRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
