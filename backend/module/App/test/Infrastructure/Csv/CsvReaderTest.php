<?php
namespace AppTest\Infrastructure\Csv;

use App\Infrastructure\Csv\CsvReader;
use App\Infrastructure\Csv\CsvReaderInterface;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CsvReaderTest extends AbstractControllerTestCase
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
     * @return CsvReader
     */
    public function getCsvReader()
    {
        return $this->getServiceManager()->get(CsvReader::class);
    }
    
    
    public function test_instantiation()
    {
        $csvReader = $this->getCsvReader();
        $this->assertInstanceOf(CsvReader::class, $csvReader);
        $this->assertInstanceOf(CsvReaderInterface::class, $csvReader);
    }
    
    
    public function test_reading_a_csv()
    {
        $csvReader = $this->getCsvReader();
        
        $csvReader->open(__DIR__ . '/sample.csv');
        $rows = $csvReader->getRows();
        
        $this->assertInstanceOf('IteratorAggregate', $rows);
    }
}
