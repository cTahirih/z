<?php
namespace AppTest\Application\Command;

use App\Application\Command\ImportUsersCsvCommand;
use App\Application\Command\ImportUsersCsvCommandHandler;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportUsersCsvCommandHandlerTest extends AbstractControllerTestCase
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
     * @return ImportUsersCsvCommandHandler
     */
    public function getCommandHandler()
    {
        return $this->getServiceManager()->get(ImportUsersCsvCommandHandler::class);
    }
    
    
    public function test_instantiation()
    {
        $handler = $this->getCommandHandler();
        $this->assertInstanceOf(ImportUsersCsvCommandHandler::class, $handler);
    }
    
    
    public function test_handle()
    {
        $this->truncateTable('users');
        
        $command = new ImportUsersCsvCommand(__DIR__ . '/Fixture/users.csv');
        $handler = $this->getCommandHandler();
        $handler->handle($command);
        
        $this->assertTableCountIs(130, 'users');
    }
}
