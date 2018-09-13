<?php
namespace AppTest\Tactician\Middleware;

use App\Tactician\Middleware\ReportCacheMiddleware;
use App\Application\Command\GetCapsuleReportCommand;
use BaseTest\Helpers;
use Mockery;
use stdClass;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheMiddlewareTest extends AbstractControllerTestCase
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
    }
    
    
    /**
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
    
    
    /**
     * @return ReportCacheMiddleware
     */
    public function getMiddleware()
    {
        return $this->getServiceManager()->get(ReportCacheMiddleware::class);
    }
    
    
    public function test_instantiation()
    {
        $middleware = $this->getMiddleware();
        $this->assertInstanceOf(ReportCacheMiddleware::class, $middleware);
    }
    
    
    public function test_execute_cache_found()
    {
        $reportCacheService = Mockery::mock('App\Application\Service\ReportCacheService')
            ->shouldReceive('get')->once()
            ->andReturn('cached-result')
            ->shouldReceive('save')->never()
            ->getMock();
        $this->setService('App\Application\Service\ReportCacheService', $reportCacheService);
        
        $middleware = $this->getMiddleware();
        
        $command = new GetCapsuleReportCommand(
            'Total',
            [
                'startMonth' => 10,
                'startYear'  => 2018,
                'endMonth'   => 12,
                'endYear'    => 2018,
            ]
        );
        
        $result = $middleware->execute($command, function ($command) { return 'command-result'; });
        
        $this->assertEquals('cached-result', $result);
    }
    
    
    public function test_execute_cache_miss()
    {
        $reportCacheService = Mockery::mock('App\Application\Service\ReportCacheService')
            ->shouldReceive('get')->once()
            ->andReturn(null)
            ->shouldReceive('save')->once()
            ->getMock();
        $this->setService('App\Application\Service\ReportCacheService', $reportCacheService);
        
        $middleware = $this->getMiddleware();
        
        $command = new GetCapsuleReportCommand(
            'Total',
            [
                'startMonth' => 10,
                'startYear'  => 2018,
                'endMonth'   => 12,
                'endYear'    => 2018,
            ]
        );
        
        $result = $middleware->execute($command, function ($command) { return 'command-result'; });
        
        $this->assertEquals('command-result', $result);
    }
    
    
    public function test_execute_cache_ignore_non_report_command()
    {
        $reportCacheService = Mockery::mock('App\Application\Service\ReportCacheService')
            ->shouldReceive('get')->never()
            ->shouldReceive('save')->never()
            ->getMock();
        $this->setService('App\Application\Service\ReportCacheService', $reportCacheService);
        
        $middleware = $this->getMiddleware();
        
        $result = $middleware->execute(new stdClass(), function ($command) { return 'command-result'; });
        
        $this->assertEquals('command-result', $result);
    }
}
