<?php
namespace AppTest\Domain\Specification;

use App\Domain\Specification\ValidDateRangeSpecification;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ValidDateRangeSpecificationTest extends AbstractControllerTestCase
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
     * @return ValidDateRangeSpecification
     */
    public function getSpecification()
    {
        return $this->getServiceManager()->get('App\Domain\Specification\ValidDateRangeSpecification');
    }
    
    
    public function test_instantiation()
    {
        $specification = $this->getSpecification();
        $this->assertInstanceOf(ValidDateRangeSpecification::class, $specification);
    }
    
    
    public function test_valid()
    {
        $specification = $this->getSpecification();
        $result = $specification->isSatisfiedBy(1, 2017, 1, 2018);
        
        $this->assertTrue($result);
    }
    
    
    public function test_invalid()
    {
        $specification = $this->getSpecification();
        $result = $specification->isSatisfiedBy('a', 'c', 'd', 'f');
        
        $this->assertFalse($result);
    }
    
    
    public function test_invalid_end_date_is_older()
    {
        $specification = $this->getSpecification();
        $result = $specification->isSatisfiedBy(1, 2018, 1, 2017);
        
        $this->assertFalse($result);
    }
    
    
    public function test_valid_equal_dates()
    {
        $specification = $this->getSpecification();
        $result = $specification->isSatisfiedBy(1, 2017, 1, 2017);
        
        $this->assertTrue($result);
    }
}
