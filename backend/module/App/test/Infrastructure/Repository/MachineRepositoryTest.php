<?php
namespace AppTest\Infrastructure\Repository;

use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Repository\MachineRepository;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineRepositoryTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @var array
     */
    protected $quantityTableRow;
    
    
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
        
        $this->quantityTableRow =[
            'total' => [
                'all'      => 0,
                'gold'     => 0,
                'platinum' => 0,
            ],
            'average' => [
                'gold'     => 0,
                'platinum' => 0,
            ],
        ];
    }
    
    
    /**
     * @return MachineRepository
     */
    public function getRepository()
    {
        return $this->getServiceManager()->get(MachineRepository::class);
    }
    
    
    public function test_instantiation()
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(MachineRepository::class, $repository);
    }
    
    
    /** Test disabled due to new schema and deferral of imports.
    public function test_insertMachinesInBatch()
    {
        // Arrange
        $this->truncateTable('machines');
        
        $repository = $this->getRepository();
        $data = $this->loadFixture('machines');
        
        // Act
        $repository->insertBatch($data);
        
        // Assert
        $this->assertTableCountIs(20, 'machines');
    }
    */
    
    
    public function test_getTotal()
    {
        $this->truncateTables(['machines'], true);
        $this->insertFixtureIntoTable('machines', 'machines');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getTotal($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
        $this->assertEquals(20, $response['all']);
    }
    
    
    public function test_getAverageByUser()
    {
        $this->truncateTable('machines');
        $this->insertFixtureIntoTable('machines', 'machines_average_by_user');
        
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
        $this->truncateTable('machines');
        $this->insertFixtureIntoTable('machines', 'machines_quantity_by_month');
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
        $this->truncateTables(['customers', 'machines'], true);
        $this->insertFixtureIntoTable('customers', 'customers_acquisition_average_by_user');
        $this->insertFixtureIntoTable('machines', 'machines_acquisition_average_by_user');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getAcquisitionAverageByUser($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_getBestMonth()
    {
        $this->truncateTable('machines');
        $this->insertFixtureIntoTable('machines', 'machines_best_month');
        
        $dateRange = new DateRange(1, 2017, 6, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getBestMonth($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('year', $response);
        $this->assertArrayHasKey('month', $response);
        $this->assertIsInteger($response['year']);
        $this->assertEquals(2018, $response['year']);
        $this->assertIsInteger($response['month']);
    }
    
    
    public function test_getBestMonth_not_found()
    {
        $this->truncateTable('machines');
        
        $dateRange = new DateRange(1, 2017, 1, 2018);
        
        $repository = $this->getRepository();
        $response = $repository->getBestMonth($dateRange);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('year', $response);
        $this->assertArrayHasKey('month', $response);
        $this->assertNull($response['year']);
        $this->assertNull($response['month']);
    }
    
    
    public function test_getEmptyQuantityTable_with_year()
    {
        $repository = $this->getRepository();
        $dateRange = new DateRange(1, 2017, 12, 2017);
        
        $expectedTable = [
            2017 => [
                1  => $this->quantityTableRow,
                2  => $this->quantityTableRow,
                3  => $this->quantityTableRow,
                4  => $this->quantityTableRow,
                5  => $this->quantityTableRow,
                5  => $this->quantityTableRow,
                6  => $this->quantityTableRow,
                7  => $this->quantityTableRow,
                8  => $this->quantityTableRow,
                9  => $this->quantityTableRow,
                10 => $this->quantityTableRow,
                11 => $this->quantityTableRow,
                12 => $this->quantityTableRow,
            ],
        ];
        
        $table = $repository->getEmptyQuantityTable($dateRange);
        
        $this->assertEquals($expectedTable, $table);
    }
    
    
    public function test_getEmptyQuantityTable_spanning_years()
    {
        $repository = $this->getRepository();
        $dateRange = new DateRange(6, 2017, 11, 2018);
        
        $expectedTable = [
            2017 => [
                6  => $this->quantityTableRow,
                7  => $this->quantityTableRow,
                8  => $this->quantityTableRow,
                9  => $this->quantityTableRow,
                10 => $this->quantityTableRow,
                11 => $this->quantityTableRow,
                12 => $this->quantityTableRow,
            ],
            2018 => [
                1  =>  $this->quantityTableRow,
                2  =>  $this->quantityTableRow,
                3  =>  $this->quantityTableRow,
                4  =>  $this->quantityTableRow,
                5  =>  $this->quantityTableRow,
                5  =>  $this->quantityTableRow,
                6  =>  $this->quantityTableRow,
                7  =>  $this->quantityTableRow,
                8  =>  $this->quantityTableRow,
                9  =>  $this->quantityTableRow,
                10 =>  $this->quantityTableRow,
                11 =>  $this->quantityTableRow,
            ],
        ];
        
        $table = $repository->getEmptyQuantityTable($dateRange);
        
        $this->assertEquals($expectedTable, $table);
    }
    
    
    public function test_getEmptyQuantityTable_same_month()
    {
        $repository = $this->getRepository();
        $dateRange = new DateRange(8, 2018, 8, 2018);
        
        $expectedTable = [
            2018 => [
                8 => $this->quantityTableRow,
            ],
        ];
        
        $table = $repository->getEmptyQuantityTable($dateRange);
        
        $this->assertEquals($expectedTable, $table);
    }
    
    
    public function test_setUsersAcquisitionAverage()
    {
        $this->truncateTables(['customers', 'machines'], true);
        $this->insertFixtureIntoTable('customers', 'customers_calculate_acquisition_average');
        $this->insertFixtureIntoTable('machines', 'machines_calculate_acquisition_average');
        
        $repository = $this->getRepository();
        
        $repository->setUsersAcquisitionAverage();
        
        $customerTg = $this->getTableGateway('customers');
        $result = $customerTg->select();
        
        $data = [];
        foreach ($result as $customer) {
            $data[$customer['customer_id']] = $customer['machine_acquisition_average'];
        }
        
        foreach ($data as $customerId => $average) {
            $this->assertTrue(is_numeric($average));
            $this->assertGreaterThan(0, $average);
        }
    }
}
