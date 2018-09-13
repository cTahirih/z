<?php
namespace App\Application\Service\Factory;

use App\Application\Service\ReportCacheService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ReportCacheService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ReportCacheService(
            $container->get('App\Infrastructure\Repository\ReportCacheRepository')
        );
    }
}
