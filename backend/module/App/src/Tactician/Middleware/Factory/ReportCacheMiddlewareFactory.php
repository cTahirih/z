<?php
namespace App\Tactician\Middleware\Factory;

use App\Tactician\Middleware\ReportCacheMiddleware;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ReportCacheMiddleware
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ReportCacheMiddleware(
            $container->get('App\Application\Service\ReportCacheService')
        );
    }
}
