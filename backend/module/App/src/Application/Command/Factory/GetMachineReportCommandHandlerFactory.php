<?php
namespace App\Application\Command\Factory;

use App\Application\Command\GetMachineReportCommandHandler;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetMachineReportCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return GetMachineReportCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GetMachineReportCommandHandler(
            $container->get('App\Infrastructure\Repository\MachineRepository')
        );
    }
}
