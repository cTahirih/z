<?php
namespace AppTest\Controller;

use App\Application\Dto\User;
use App\Controller\LoginController;
use BaseTest\Helpers;
use Mockery;
use Zend\Form\Form;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * @see AbstractHttpControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginControllerTest extends AbstractHttpControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            include __DIR__ . '/../../../../config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
        
        // Force `show_backend_template`
        $this->setConfig(function ($config) {
            $config['show_backend_template'] = true;
            return $config;
        });
    }
    
    
    /**
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
    
    
    /**
     * @return Form
     */
    public function getLoginForm()
    {
        return $this
            ->getServiceManager()
            ->get('FormElementManager')
            ->get('App\Form\LoginForm');
    }
    
    
    public function test_controller()
    {
        $controller = $this
            ->getServiceManager()
            ->get('ControllerManager')
            ->get('App\Controller\LoginController');
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $controller);
    }
    
    
    public function test_login_works()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
    }
    
    
    public function test_user_can_log_in()
    {
        // Arrange
        $form = $this->getLoginForm();
        $handler = Mockery::mock('App\Application\Command\GetUserForLoginCommandHandler')
            ->shouldReceive('handle')->once()
            ->andReturn(new User(123, 'jgwong'))
            ->getMock();
        $this->setService('App\Application\Command\GetUserForLoginCommandHandler', $handler);
        $session = $this->getServiceManager()->get('App\Infrastructure\Session');
        
        // Act
        $data = [
            'username' => 'admin',
            'password' => 123,
            'csrf'     => $form->get('csrf')->getValue(),
        ];
        
        $this->dispatch('/', 'POST', $data);
        
        // Assert
        $this->assertRedirectTo('/dashboard');
        $this->assertTrue($session->isUserLoggedIn());
    }
    
    
    public function test_logout()
    {
        $session = $this->getServiceManager()->get('App\Infrastructure\Session');
        $session['user'] = 1;
        
        $this->dispatch('/logout');
        
        $this->assertRedirectTo('/');
        $this->assertFalse($session->isUserLoggedIn());
    }
}
