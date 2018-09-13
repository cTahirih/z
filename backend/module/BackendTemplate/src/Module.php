<?php
namespace BackendTemplate;

use RuntimeException;
use Zend\Mvc\MvcEvent;

/**
 * @package BackendTemplate
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        // Verify zendframework/zend-view is present
        if (!file_exists('vendor/zendframework/zend-view')) {
            throw new RuntimeException('BackendTemplate module could not bootstrap. zend-view is not installed.');
        }
        
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'backendTemplateProcess'], -500);
    }
    
    
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function backendTemplateProcess(MvcEvent $mvcEvent)
    {
        $serviceManager   = $mvcEvent->getApplication()->getServiceManager();
        $config           = $serviceManager->get('Config');
        $templateResolver = $serviceManager->get('Zend\View\Resolver\TemplatePathStack');
        
        if (BackendTemplate::isActive($config) == false) {
            return;
        }
        
        $template = $mvcEvent->getResult()->getTemplate();
        $template = BackendTemplate::addPrefix($template);
        
        // Replace, but only if the view indeed exists
        if ($templateResolver->resolve($template)) {
            $mvcEvent->getResult()->setTemplate($template);
        }
    }
}
