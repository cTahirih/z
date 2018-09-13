<?php
namespace AdminAuth2\Test;

use PHPUnit_Framework_TestCase;
use SkelsusTests\ServiceManagerGrabber;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Mockery as m;

use AdminAuth2\Provider\ProviderField;

class ProviderFieldTest extends AbstractHttpControllerTestCase
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
    
    
    public function testProviderField()
    {
        $foo = m::mock('foo')
             ->shouldReceive('bar')
             ->getMock();
        
        $field = new ProviderField('student', [$foo, 'bar']);
        $field->getValue();
        
        $this->assertTrue(is_callable($field->getRawValue()));
        
        $method = 'bar';
        $field->setMethod($method);
        $this->assertEquals([$foo, $method], $field->getRawValue());
    }
}
