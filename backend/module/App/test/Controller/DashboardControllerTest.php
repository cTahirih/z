<?php
namespace AppTest\Controller;

use App\Controller\DashboardController;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * @see AbstractHttpControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DashboardControllerTest extends AbstractHttpControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include 'config/application.config.php',
            include 'config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
        
        // Force `show_backend_template`
        $this->setConfig(function ($config) {
            $config['show_backend_template'] = true;
            return $config;
        });
    }
    
    
    public function test_controller()
    {
        $controller = $this
            ->getServiceManager()
            ->get('ControllerManager')
            ->get('App\Controller\DashboardController');
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $controller);
    }
    
    
    public function test_dashboard_logged_in()
    {
        $session = $this->getServiceManager()->get('App\Infrastructure\Session');
        $session['user'] = true;
        
        $this->dispatch('/dashboard');
        $this->assertResponseStatusCode(200);
    }
    
    
    public function test_should_redirect_if_not_logged_in()
    {
        $this->dispatch('/dashboard');
        $this->assertRedirectTo('/');
    }
}
