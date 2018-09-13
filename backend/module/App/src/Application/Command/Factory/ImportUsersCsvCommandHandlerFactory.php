<?php
namespace App\Application\Command\Factory;

use App\Application\Command\ImportUsersCsvCommandHandler;
use App\Infrastructure\Csv\UserFieldsMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportUsersCsvCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ImportUsersCsvCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ImportUsersCsvCommandHandler(
            $container->get('App\Infrastructure\Csv\CsvReader'),
            $container->get('App\Infrastructure\Repository\UserRepository'),
            new UserFieldsMapper()
        );
    }
}
