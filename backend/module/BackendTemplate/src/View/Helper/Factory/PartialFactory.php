<?php
/**
 * This file is part of Website Zend Framework 2 module.
 */

namespace BackendTemplate\View\Helper\Factory;

use BackendTemplate\BackendTemplate;
use BackendTemplate\View\Helper\Partial;
use Interop\Container\ContainerInterface;
use Zend\View\Helper\Partial as ZendViewPartial;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package BackendTemplate
 * @author Jaime G. Wong <j@jgwong.org>
 */
class PartialFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $serviceLocator
     * @return Partial
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        // Detect if Backend Template is active
        $config   = $serviceLocator->get('Config');
        $isActive = BackendTemplate::isActive($config);
        
        if ($isActive) {
            return new Partial(
                $serviceLocator->get('Zend\View\Resolver\TemplatePathStack')
            );
        }
        
        // If not, then return the original Zend View Partial helper
        return new ZendViewPartial();
    }
}
