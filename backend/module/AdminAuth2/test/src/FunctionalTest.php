<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\Form\LoginForm;

class FunctionalTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    protected $superuserPassword = 'pikachu123';
    
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testRoutesWork()
    {
        $this->dispatch('/admin');
        $this->assertResponseStatusCode(200);
        $this->reset();
        
        $this->dispatch('/admin/admin_users');
        $this->assertRedirectTo('/admin');
        $this->reset();
    }
    
    
    public function setupSuperuser()
    {
        $adminUserService = $this->getApplicationServiceLocator()->get('AdminAuth2\Service\AdminUserService');
        $adminRoleService = $this->getApplicationServiceLocator()->get('AdminAuth2\Service\AdminRoleService');
        
        $this->truncateTable(['admin_roles', 'admin_users'], true);
        
        $adminRoleService->createAdminRole();
        $adminUserService->createSuperuser($this->superuserPassword);
    }
    
    
    public function testLogin()
    {
        $this->setupSuperuser();
        $this->dispatch('/admin');
        
        // Get CSRF token
        $body = $this->getResponse()->getContent();
        
        if (!preg_match("/csrf\".+?value=\"(.+?)\"/m", $body, $matches)) {
            throw new \RuntimeException('CSRF token could not be fetched.');
        }
        
        $csrf = $matches[1];
        
        $this->dispatch('/admin', 'POST', [
            'username' => 'admin',
            'password' => $this->superuserPassword,
            'csrf'     => $csrf,
        ]);
        
        $this->assertRedirectTo('/admin/dashboard');
    }
}
