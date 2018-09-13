<?php
namespace AppTest\Application\Command;

use App\Application\Command\GetMachineReportCommand;
use App\Application\Command\GetMachineReportCommandHandler;
use BaseTest\Helpers;
use Mockery;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetMachineReportCommandHandlerTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @var string
     */
    protected $repositoryClass = 'App\Infrastructure\Repository\MachineRepository';
    
    
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
     * @return GetMachineReport
     */
    public function getCommandHandler()
    {
        return $this->getServiceManager()->get(GetMachineReportCommandHandler::class);
    }
    
    
    public function test_instantiation()
    {
        $handler = $this->getCommandHandler();
        $this->assertInstanceOf('DDD\Command\CommandHandlerInterface', $handler);
        $this->assertInstanceOf(GetMachineReportCommandHandler::class, $handler);
    }
    
    
    /**
     * @return array
     */
    public function getDateRangeArray()
    {
        return [
            'startMonth' => 1,
            'startYear'  => 2017,
            'endMonth'   => 1,
            'endYear'    => 2018,
        ];
    }
    
    
    public function test_Total()
    {
        // Setup Repository mock
        $repository = Mockery::mock($this->repositoryClass)
            ->shouldReceive('getTotal')->once()
            ->andReturn([
                'all'      => 0,
                'gold'     => 0,
                'platinum' => 0,
            ])
            ->getMock();
        $this->setService($this->repositoryClass, $repository);
        
        $command = new GetMachineReportCommand(
            'Total',
            $this->getDateRangeArray()
        );
        
        $handler = $this->getCommandHandler();
        $response = $handler->handle($command);
        
        $this->assertInstanceOf(
            'App\Application\Dto\Report\MachinesTotal',
            $response
        );
    }
    
    
    public function test_AverageByUser()
    {
        // Setup Repository mock
        $repository = Mockery::mock($this->repositoryClass)
            ->shouldReceive('getAverageByUser')->once()
            ->andReturn([
                'all'      => 0,
                'platinum' => 0,
                'gold'     => 0,
            ])
            ->getMock();
        $this->setService($this->repositoryClass, $repository);
        
        $command = new GetMachineReportCommand(
            'AverageByUser',
            $this->getDateRangeArray()
        );
        
        $handler = $this->getCommandHandler();
        $response = $handler->handle($command);
        
        $this->assertInstanceOf(
            'App\Application\Dto\Report\MachinesAverageByUser',
            $response
        );
    }
    
    
    public function test_QuantityByMonth()
    {
        // Setup Repository mock
        $repository = Mockery::mock($this->repositoryClass)
            ->shouldReceive('getQuantityByMonth')->once()
            ->andReturn([
                [
                    'month'   => 1,
                    'year'    => 2018,
                    'total'   => [
                        'all'      => 0,
                        'gold'     => 0,
                        'platinum' => 0,
                    ],
                    'average' => [
                        'all'      => 0,
                        'gold'     => 0,
                        'platinum' => 0,
                    ],
                ],
            ])
            ->getMock();
        $this->setService($this->repositoryClass, $repository);
        
        $command = new GetMachineReportCommand(
            'QuantityByMonth',
            $this->getDateRangeArray()
        );
        
        $handler = $this->getCommandHandler();
        $response = $handler->handle($command);
        
        $this->assertInstanceOf(
            'App\Application\Dto\Report\MachinesQuantityByMonth',
            $response
        );
    }
    
    
    public function test_AcquisitionAverageByUser()
    {
        // Setup Repository mock
        $repository = Mockery::mock($this->repositoryClass)
            ->shouldReceive('getAcquisitionAverageByUser')->once()
            ->andReturn([
                'all'      => 0,
                'gold'     => 0,
                'platinum' => 0,
            ])
            ->getMock();
        $this->setService($this->repositoryClass, $repository);
        
        $command = new GetMachineReportCommand(
            'AcquisitionAverageByUser',
            $this->getDateRangeArray()
        );
        
        $handler = $this->getCommandHandler();
        $response = $handler->handle($command);
        
        $this->assertInstanceOf(
            'App\Application\Dto\Report\MachinesAcquisitionAverageByUser',
            $response
        );
    }
    
    
    public function test_BestMonth()
    {
        // Setup Repository mock
        $repository = Mockery::mock($this->repositoryClass)
            ->shouldReceive('getBestMonth')->once()
            ->andReturn([
                'month' => 1,
                'year'  => 2018,
            ])
            ->getMock();
        $this->setService($this->repositoryClass, $repository);
        
        $command = new GetMachineReportCommand(
            'BestMonth',
            $this->getDateRangeArray()
        );
        
        $handler = $this->getCommandHandler();
        $response = $handler->handle($command);
        
        $this->assertInstanceOf(
            'App\Application\Dto\Report\MachinesBestMonth',
            $response
        );
    }
}
