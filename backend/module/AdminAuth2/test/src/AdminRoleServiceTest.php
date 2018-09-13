<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AdminRoleServiceTestTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testCreateAdminRole()
    {
        $this->truncateTable('admin_roles', true);
        
        $adminRoleService = $this->getApplicationServiceLocator()->get('AdminAuth2\Service\AdminRoleService');
        $adminRoleTable = $this->getTableGateway('admin_roles');
        
        $adminRoleService->createAdminRole();
        
        $admin = $adminRoleTable->select(['name' => 'Admin'])->current();
        $this->assertInstanceOf('ArrayObject', $admin);
    }
}
