<?php
namespace AdminAuth2\Skelsus\Console\Command\Factory;

use AdminAuth2\Skelsus\Console\Command\ChangeUserPasswordCommand;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ChangeUserPasswordCommandFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ChangeUserPasswordCommand
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ChangeUserPasswordCommand(
            $container->get('AdminAuth2\Service\AdminUserService')
        );
    }
}
