<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\Entity\AdminUser;

class AdminUserServiceTestTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testCreateSuperuser()
    {
        $this->truncateTable(['admin_roles', 'admin_users'], true);
        
        $adminRoleService = $this->getApplicationServiceLocator()->get('AdminAuth2\Service\AdminRoleService');
        $adminUserService = $this->getApplicationServiceLocator()->get('AdminAuth2\Service\AdminUserService');
        $adminUserTable = $this->getTableGateway('admin_users');
        
        $this->assertFalse($adminUserService->existsSuperuser());
        
        $adminRoleService->createAdminRole();
        $adminUserService->createSuperuser('123');
        
        $superuser = $adminUserTable->select(['username' => 'admin'])->current();
        $this->assertInstanceOf('ArrayObject', $superuser);
        
        $this->assertTrue($adminUserService->existsSuperuser());
        
        $user = $adminUserService->getUserWithLogin('admin', '123');
        $this->assertInstanceOf('AdminAuth2\Entity\AdminUser', $user);
        
        $newUser = new AdminUser();
        $newUser->setUsername('testy');
        $newUser->setName('Test');
        $newUser->setPassword('123');
        $newUser->setRole($user->getRole());
        
        $adminUserService->save($newUser);
        
        $user = $adminUserService->getUserWithUsername('testy');
        $this->assertInstanceOf('AdminAuth2\Entity\AdminUser', $user);
    }
}
