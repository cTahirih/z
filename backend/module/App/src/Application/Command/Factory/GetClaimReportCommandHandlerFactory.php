<?php
namespace App\Application\Command\Factory;

use App\Application\Command\GetClaimReportCommandHandler;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetClaimReportCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return GetClaimReportCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GetClaimReportCommandHandler(
            $container->get('App\Infrastructure\Repository\ClaimRepository')
        );
    }
}
