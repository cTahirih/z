<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\Provider\AdminUserProvider;

class AdminUserRoleProviderTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testProviders()
    {
        $providers = [
            'AdminAuth2\Provider\AdminUserProvider',
            'AdminAuth2\Provider\AdminRoleProvider',
        ];
        
        foreach ($providers as $providerClass) {
            $provider = $this->getApplicationServiceLocator()->get($providerClass);
            
            $this->assertInstanceOf($providerClass, $provider);
            $this->assertInstanceOf('AdminAuth2\Provider\CrudProviderInterface', $provider);
            $this->assertInstanceOf('AdminAuth2\Provider\ListProviderInterface', $provider);
            
            $this->assertTrue(is_array($provider->getListFields()));
            $this->assertTrue(is_array($provider->getViewFields()));
            $this->assertInstanceOf('Zend\Form\Form', $provider->getForm('add'));
        }
    }
}
