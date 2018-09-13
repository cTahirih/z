<?php
namespace App;

use Locale;
use Zend\Http\Response as HttpResponse;
use Zend\I18n\Translator\Resources;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use Zend\Validator\AbstractValidator;

/**
 * @package App
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
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        
        $this->setupTimezone();
        $this->setupLocale();
        $this->setupTranslator($mvcEvent);
        $this->setupSessions($mvcEvent);
    }
    
    
    /**
     * @return void
     */
    public function setupTimezone()
    {
        date_default_timezone_set('America/Lima');
    }
    
    
    /**
     * @return void
     */
    public function setupLocale() {
        Locale::setDefault('es_PE');
        setlocale(LC_TIME, 'es_PE');
    }
    
    
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function setupTranslator(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        
        $translator = $serviceManager->get('MvcTranslator');
        $translator->setLocale('es');
        $translator->setFallbackLocale('en');
        $translator->addTranslationFilePattern(
            'phpArray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );
        $translator->addTranslationFilePattern(
            'phpArray',
            Resources::getBasePath(),
            Resources::getPatternForCaptcha()
        );
        
        AbstractValidator::setDefaultTranslator($translator);
    }
    
    
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function setupSessions(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $config         = $serviceManager->get('Config');
        $eventManager   = $mvcEvent->getApplication()->getEventManager();
        
        if (!isset($config['session_config'])) {
            throw new \RuntimeException('Configuration is missing a "session_config" key, or the value of that key is not an array');
        }
        
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session_config']);
        
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->getValidatorChain()->attach('session.validate', array(new HttpUserAgent(), 'isValid'));
        $sessionManager->getValidatorChain()->attach('session.validate', array(new RemoteAddr(), 'isValid'));
        Container::setDefaultManager($sessionManager);
        
        // Attach to RENDER event to add security headers
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'addSecurityHeadersListener'), 100);
    }
    
    
    /**
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function addSecurityHeadersListener(MvcEvent $mvcEvent)
    {
        $response = $mvcEvent->getResponse();
        
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
