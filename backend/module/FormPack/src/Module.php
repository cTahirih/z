<?php
namespace FormPack;

use Zend\Mvc\MvcEvent;
use Zend\Form\View\Helper\FormElement;

/**
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Module
{
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        
        // Configure Zend's FormElement Helper
        $this->configureFormElement($serviceManager->get('ViewHelperManager')->get('FormElement'));
    }
    
    
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    
    /**
     * Add our Form Element's View Helpers.
     *
     * @param FormElement $formElement
     * @return void
     */
    public function configureFormElement(FormElement $formElement)
    {
        $formElement->addType('optionalfile', 'formoptionalfile');
        $formElement->addType('imagefile', 'formimagefile');
    }
}
