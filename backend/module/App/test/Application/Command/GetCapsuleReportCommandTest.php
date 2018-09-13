<?php
namespace AppTest\Application\Command;

use App\Application\Command\GetCapsuleReportCommand;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetCapsuleReportCommandTest extends AbstractControllerTestCase
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
    
    
    public function test_invalid()
    {
        $this->expectException('RuntimeException');
        
        $command = new GetCapsuleReportCommand(
            'Invalid',
            [
                'startMonth' => 1,
                'startYear'  => 2017,
                'endMonth'   => 1,
                'endYear'    => 2018,
            ]
        );
    }
    
    
    public function test_Total()
    {
        $command = new GetCapsuleReportCommand(
            'Total',
            [
                'startMonth' => 1,
                'startYear'  => 2017,
                'endMonth'   => 1,
                'endYear'    => 2018,
            ]
        );
        
        $this->assertInstanceOf(GetCapsuleReportCommand::class, $command);
    }
    
    
    public function test_invalid_Total()
    {
        $this->expectException('RuntimeException');
        
        $command = new GetCapsuleReportCommand(
            'Total',
            [
                'startMonth' => 1,
                'startYear'  => 2017,
            ]
        );
    }
}
