<?php
namespace App\Application\Command\Factory;

use App\Application\Command\GetUserForLoginCommandHandler;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetUserForLoginCommandHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return GetUserForLoginCommandHandler
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GetUserForLoginCommandHandler(
            $container->get('AdminAuth2\Service\AdminUserService')
        );
    }
}
