<?php
namespace AppTest\Application\Service;

use App\Application\Service\ReportCacheService;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheServiceTest extends AbstractControllerTestCase
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
     * @return ReportCacheService
     */
    public function getService()
    {
        return $this->getServiceManager()->get(ReportCacheService::class);
    }
    
    
    public function test_instantiation()
    {
        $service = $this->getService();
        $this->assertInstanceOf(ReportCacheService::class, $service);
    }
}
