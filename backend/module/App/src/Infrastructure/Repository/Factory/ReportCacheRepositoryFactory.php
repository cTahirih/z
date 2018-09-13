<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\ReportCacheRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ReportCacheRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ReportCacheRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
