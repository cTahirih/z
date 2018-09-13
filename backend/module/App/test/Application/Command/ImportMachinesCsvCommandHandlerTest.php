<?php
namespace AppTest\Application\Command;

use App\Application\Command\ImportMachinesCsvCommand;
use App\Application\Command\ImportMachinesCsvCommandHandler;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportMachinesCsvCommandHandlerTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $this->markTestSkipped('Skipped due to schema mismatch');
        
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include 'config/application.config.php',
            include 'config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
    }
    
    
    /**
     * @return ImportMachinesCsvCommandHandler
     */
    public function getCommandHandler()
    {
        return $this->getServiceManager()->get(ImportMachinesCsvCommandHandler::class);
    }
    
    
    public function test_instantiation()
    {
        $handler = $this->getCommandHandler();
        $this->assertInstanceOf(ImportMachinesCsvCommandHandler::class, $handler);
    }
    
    
    public function test_handle()
    {
        $this->truncateTable('machines');
        
        $command = new ImportMachinesCsvCommand(__DIR__ . '/Fixture/machines.csv');
        $handler = $this->getCommandHandler();
        $handler->handle($command);
        
        $this->assertTableCountIs(46, 'machines');
    }
}
