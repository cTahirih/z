<?php
namespace AdminAuth2\Skelsus\Console\Command\Factory;

use AdminAuth2\Skelsus\Console\Command\CreateSuperUserCommand;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CreateSuperUserCommandFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return CreateSuperUserCommand
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CreateSuperUserCommand(
            $container->get('AdminAuth2\Service\AdminUserService'),
            $container->get('AdminAuth2\Service\AdminRoleService')
        );
    }
}
