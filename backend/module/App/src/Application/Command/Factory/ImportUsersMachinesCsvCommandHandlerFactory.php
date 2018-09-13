<?php
namespace App\Application\Command\Factory;

use App\Application\Command\ImportUsersMachinesCsvCommandHandler;
use App\Infrastructure\Csv\UserMachineFieldsMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportUsersMachinesCsvCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ImportUsersMachinesCsvCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ImportUsersMachinesCsvCommandHandler(
            $container->get('App\Infrastructure\Csv\CsvReader'),
            $container->get('App\Infrastructure\Repository\UserMachineRepository'),
            new UserMachineFieldsMapper()
        );
    }
}
