<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\Entity\AdminRole;

class AdminRoleEntityTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testAdminRole()
    {
        $resources = [
            'students' => [
                'list',
                'view',
            ],
            
            'teachers' => [
                'list',
                'view',
                'add',
                'edit',
                'delete'
            ],
        ];
        
        $adminRole = new AdminRole();
        $adminRole->setResources(json_encode($resources));
        
        $this->assertTrue(is_string($adminRole->getResources()));
        $this->assertTrue(is_array($adminRole->getResourcesAsArray()));
        $this->assertEquals($resources, $adminRole->getResourcesAsArray());
    }
}

