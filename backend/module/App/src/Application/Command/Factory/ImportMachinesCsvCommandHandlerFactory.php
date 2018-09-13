<?php
namespace App\Application\Command\Factory;

use App\Application\Command\ImportMachinesCsvCommandHandler;
use App\Infrastructure\Csv\MachineFieldsMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportMachinesCsvCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ImportMachinesCsvCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ImportMachinesCsvCommandHandler(
            $container->get('App\Infrastructure\Csv\CsvReader'),
            $container->get('App\Infrastructure\Repository\MachineRepository'),
            new MachineFieldsMapper()
        );
    }
}
