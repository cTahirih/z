<?php
namespace AdminAuth2;

use AdminAuth2\Skelsus\Console\Command\ChangeUserPasswordCommand;
use AdminAuth2\Skelsus\Console\Command\CreateSuperUserCommand;
use AdminAuth2\Skelsus\Console\Command\UpdateAdminPermsCommand;
use Base\SkelsusCommandProviderInterface;
use Interop\Container\ContainerInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

/**
 * @see DependencyIndicatorInterface
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Module implements DependencyIndicatorInterface,
                        SkelsusCommandProviderInterface
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    
    /**
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            'Base',
            'FormPack'
        ];
    }
    
    
    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function getSkelsusCommands(ContainerInterface $container)
    {
        return [
            $container->get('AdminAuth2\Skelsus\Console\Command\CreateSuperUserCommand'),
            $container->get('AdminAuth2\Skelsus\Console\Command\ChangeUserPasswordCommand'),
            $container->get('AdminAuth2\Skelsus\Console\Command\UpdateAdminPermsCommand'),
        ];
    }
}
