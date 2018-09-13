<?php
namespace App\Application\Command\Factory;

use App\Application\Command\GetCapsuleReportCommandHandler;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetCapsuleReportCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return GetCapsuleReportCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GetCapsuleReportCommandHandler(
            $container->get('App\Infrastructure\Repository\CapsuleRepository')
        );
    }
}
