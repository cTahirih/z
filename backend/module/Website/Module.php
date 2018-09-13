<?php
/**
 * This file is part of Website Zend Framework 2 module.
 */

namespace Website;

use Locale;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use Zend\Validator\AbstractValidator;

class Module
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        
        // Configure translator
        $translator = $serviceManager->get('MvcTranslator');
        $translator->setLocale('es_ES')->setFallbackLocale('es_ES');
        
        foreach (array('Zend_Captcha', 'Zend_Validate') as $f) {
            $translator->addTranslationFile(
                'phpArray',
                'vendor/zendframework/zendframework/resources/languages/es/' . $f . '.php',
                'default',
                'es_ES'
            );
        }
        
        date_default_timezone_set('America/Lima');
        Locale::setDefault('es_ES');
        setlocale(LC_TIME, 'es_ES');
        
        AbstractValidator::setDefaultTranslator($translator);
        
        // Set settings for Sessions
        $config = $serviceManager->get('Config');
        
        if (!isset($config['session_config'])) {
            throw new \RuntimeException('Configuration is missing a "session_config" key, or the value of that key is not an array');
        }
        
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session_config']);
        
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->getValidatorChain()->attach('session.validate', array(new HttpUserAgent(), 'isValid'));
        $sessionManager->getValidatorChain()->attach('session.validate', array(new RemoteAddr(), 'isValid'));
        Container::setDefaultManager($sessionManager);
        
        // Attach RENDER event to add security headers
        $eventManager   = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'onRender'), 100);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                   __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    /**
     * Event callback for Security headers
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onRender(MvcEvent $e)
    {
        $response = $e->getResponse();
        
        if ($response instanceof HttpResponse) {
            $response->getHeaders()
                ->addHeaderLine('X-Frame-Options: DENY')
                ->addHeaderLine('X-XSS-Protection:1; mode=block')
                ->addHeaderLine('X-Permitted-Cross-Domain-Policies: master-only')
                ->addHeaderLine('X-Content-Type-Options: nosniff')
                ->addHeaderLine('X-Content-Security-Policy: allow \'self\'');
        }
    }
}
