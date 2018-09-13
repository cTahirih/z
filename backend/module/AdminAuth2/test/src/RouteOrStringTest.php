<?php
namespace AdminAuth2\Test;

use Mockery as m;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use AdminAuth2\ViewHelper\RouteOrString;

class RouteOrStringTest extends AbstractHttpControllerTestCase
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
        m::close();
    }
    
    
    public function testInvalidParameter()
    {
        $this->setExpectedException('RuntimeException');
        $routeOrString = new RouteOrString();
        $routeOrString->__invoke(10);
    }
    
    
    public function testValidArrayNoParams()
    {
        $routeOrString = m::mock('AdminAuth2\ViewHelper\RouteOrString')
            ->shouldDeferMissing()
            ->shouldReceive('__invoke')
                ->once()
                ->passthru()
            ->getMock();
        
        $view = m::mock('Zend\View\Renderer\RendererInterface')
            ->shouldReceive('url')
            ->once()
            ->with('route', [])
            ->andReturn('OK')
            ->getMock();
        $routeOrString->setView($view);
        
        $result = $routeOrString->__invoke(['route']);
        $this->assertEquals($result, 'OK');
    }
    
    
    public function testValidArrayWithParams()
    {
        $routeOrString = m::mock('AdminAuth2\ViewHelper\RouteOrString')
            ->shouldDeferMissing()
            ->shouldReceive('__invoke')
                ->once()
                ->passthru()
            ->getMock();
        
        $view = m::mock('Zend\View\Renderer\RendererInterface')
            ->shouldReceive('url')
            ->once()
            ->with('route', ['param' => 'value'])
            ->andReturn('OK')
            ->getMock();
        $routeOrString->setView($view);
        
        $result = $routeOrString->__invoke(['route', ['param' => 'value']]);
        $this->assertEquals($result, 'OK');
    }
    
    
    public function testInvalidEmptyArray()
    {
        $this->setExpectedException('RuntimeException');
        
        $routeOrString = new RouteOrString();
        $routeOrString([]);
    }
    
    
    public function testInvalidNoStringRouteArray()
    {
        $this->setExpectedException('RuntimeException');
        
        $routeOrString = new RouteOrString();
        $routeOrString([10]);
    }
}
