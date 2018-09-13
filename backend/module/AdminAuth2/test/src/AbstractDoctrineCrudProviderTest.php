<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Mockery as m;

class AbstractDoctrineCrudProviderTest extends AbstractHttpControllerTestCase
{
    use \BaseTest\Helpers;
    
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    public function tearDown()
    {
        m::Close();
    }
    
    
    public function testProvider()
    {
        $provider = m::mock('AdminAuth2\Provider\AbstractDoctrineCrudProvider')
            ->shouldReceive('b')
            ->getMock();
        
        $provider->getFields();
    }
}
