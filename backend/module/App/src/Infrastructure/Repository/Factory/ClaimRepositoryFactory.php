<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\ClaimRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ClaimRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ClaimRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ClaimRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
