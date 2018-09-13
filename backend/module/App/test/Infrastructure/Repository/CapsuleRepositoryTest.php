<?php
namespace AppTest\Infrastructure\Repository;

use App\Infrastructure\Repository\CapsuleRepository;
use App\Domain\ValueObject\DateRange;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CapsuleRepositoryTest extends AbstractControllerTestCase
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
     * @return CapsuleRepository
     */
    public function getRepository()
    {
        return $this->getServiceManager()->get(CapsuleRepository::class);
    }
    
    
    public function test_instantiation()
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(CapsuleRepository::class, $repository);
    }
    
    
    public function test_getTotal()
    {
        $this->truncateTables(['capsules'], true);
        $this->insertFixtureIntoTable('capsules', 'capsules');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getTotal($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_getAverageByUser()
    {
        $this->truncateTable('capsules');
        $this->insertFixtureIntoTable('capsules', 'capsules_average_by_user');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getAverageByUser($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_getQuantityByMonth()
    {
        $this->truncateTable('capsules');
        $this->insertFixtureIntoTable('capsules', 'capsules_quantity_by_month');
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getQuantityByMonth($dateRange);
        
        $this->assertIsArray($response);
        
        foreach ($response as $row) {
            $this->assertArrayHasKey('month', $row);
            $this->assertArrayHasKey('year', $row);
            
            $this->assertArrayHasKey('total', $row);
            $this->assertArrayHasKey('all', $row['total']);
            $this->assertArrayHasKey('gold', $row['total']);
            $this->assertArrayHasKey('platinum', $row['total']);
            
            $this->assertArrayHasKey('average', $row);
            $this->assertArrayHasKey('gold', $row['average']);
            $this->assertArrayHasKey('platinum', $row['average']);
        }
    }
}
