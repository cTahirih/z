<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\Entity\AdminUser;

class AdminUserEntityTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function testPasswordEncryption()
    {
        $adminUser = new AdminUser();
        
        $password = 'pikachu123';
        $adminUser->setPassword($password);
        
        $this->assertTrue($adminUser->passwordMatches($password));
        
        $adminUser->setPassword($password, false);
        $this->assertEquals($password, $adminUser->getPassword());
    }
}
