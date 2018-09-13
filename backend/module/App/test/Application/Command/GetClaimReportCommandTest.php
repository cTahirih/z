<?php
namespace AppTest\Application\Command;

use App\Application\Command\GetClaimReportCommand;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetClaimReportCommandTest extends AbstractControllerTestCase
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
        
        $command = new GetClaimReportCommand(
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
        $command = new GetClaimReportCommand(
            'Total',
            [
                'startMonth' => 1,
                'startYear'  => 2017,
                'endMonth'   => 1,
                'endYear'    => 2018,
            ]
        );
        
        $this->assertInstanceOf(GetClaimReportCommand::class, $command);
    }
    
    
    public function test_invalid_Total()
    {
        $this->expectException('RuntimeException');
        
        $command = new GetClaimReportCommand(
            'Total',
            [
                'startMonth' => 1,
                'startYear'  => 2017,
            ]
        );
    }
}
