<?php
/**
 * This file is part of Website Zend Framework 2 module.
 */

namespace Website\Controller\Factory;

use Website\Controller\WebsiteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * WebsiteControllerFactory
 *
 * @package Website
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class WebsiteControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $controllerManager
     * @return WebsiteController
     * @since v1.0.0
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();
        return new WebsiteController();
    }
}
