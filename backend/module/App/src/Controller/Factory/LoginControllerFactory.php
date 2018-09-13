<?php
namespace App\Controller\Factory;

use App\Controller\LoginController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return LoginController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formElementMgr = $container->get('FormElementManager');
        
        return new LoginController(
            $container->get('App\Infrastructure\Session'),
            $formElementMgr->get('App\Form\LoginForm')
        );
    }
}
