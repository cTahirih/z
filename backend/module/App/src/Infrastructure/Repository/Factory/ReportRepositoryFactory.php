<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\ReportRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ReportRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ReportRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
