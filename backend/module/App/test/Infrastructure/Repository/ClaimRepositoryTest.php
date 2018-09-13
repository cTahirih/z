<?php
namespace AppTest\Infrastructure\Repository;

use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Repository\ClaimRepository;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ClaimRepositoryTest extends AbstractControllerTestCase
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
     * @return ClaimRepository
     */
    public function getRepository()
    {
        return $this->getServiceManager()->get(ClaimRepository::class);
    }
    
    
    public function test_instantiation()
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(ClaimRepository::class, $repository);
    }
    
    
    public function test_getTotal()
    {
        $this->truncateTables(['customers', 'claims'], true);
        $this->insertFixtureIntoTable('customers', 'customers');
        $this->insertFixtureIntoTable('claims', 'claims');
        
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
        $this->truncateTables(['customers', 'claims'], true);
        $this->insertFixtureIntoTable('customers', 'customers');
        $this->insertFixtureIntoTable('claims', 'claims_average_by_user');
        
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
        $this->truncateTables(['customers', 'claims'], true);
        $this->insertFixtureIntoTable('customers', 'customers');
        $this->insertFixtureIntoTable('claims', 'claims_quantity_by_month');
        
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
    
    
    public function test_getAcquisitionAverageByUser()
    {
        $this->truncateTables(['customers', 'claims'], true);
        $this->insertFixtureIntoTable('customers', 'customers_acquisition_average_by_user');
        $this->insertFixtureIntoTable('claims', 'claims_acquisition_average_by_user');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getAcquisitionAverageByUser($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_setUsersAcquisitionAverage()
    {
        $this->truncateTables(['customers', 'claims'], true);
        $this->insertFixtureIntoTable('customers', 'customers_calculate_acquisition_average');
        $this->insertFixtureIntoTable('claims', 'claims_calculate_acquisition_average');
        
        $repository = $this->getRepository();
        
        $repository->setUsersAcquisitionAverage();
        
        $customerTg = $this->getTableGateway('customers');
        $result = $customerTg->select();
        
        $data = [];
        foreach ($result as $customer) {
            $data[$customer['customer_id']] = $customer['claim_acquisition_average'];
        }
        
        foreach ($data as $customerId => $average) {
            $this->assertTrue(is_numeric($average));
            $this->assertGreaterThan(0, $average);
        }
    }
}
