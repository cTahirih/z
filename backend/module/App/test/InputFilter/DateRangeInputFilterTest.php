<?php
namespace AppTest\InputFilter;

use App\InputFilter\DateRangeInputFilter;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DateRangeInputFilterTest extends AbstractControllerTestCase
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
     * @return DateRangeInputFilter
     */
    public function getInputFilter()
    {
        return $this->getServiceManager()->get(DateRangeInputFilter::class);
    }
    
    
    public function test_instantiation()
    {
        $inputFilter = $this->getInputFilter();
        $this->assertInstanceOf(DateRangeInputFilter::class, $inputFilter);
    }
    
    
    public function test_valid()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData([
            'start_month' => '12',
            'start_year'  => '2017',
            'end_month'   => '01',
            'end_year'    => '2018',
        ]);
        
        $result = $inputFilter->isValid();
        
        $this->assertTrue($result);
    }
    
    
    public function test_invalid()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData([
            'start_month' => 'A',
            'start_year'  => 'B',
            'end_month'   => 'C',
            'end_year'    => 'D',
        ]);
        
        $result = $inputFilter->isValid();
        $invalids = $inputFilter->getInvalidInput();
        
        $this->assertFalse($result);
        $this->assertArrayHasKey('start_month', $invalids);
        $this->assertArrayHasKey('start_year', $invalids);
        $this->assertArrayHasKey('end_month', $invalids);
        $this->assertArrayHasKey('end_year', $invalids);
    }
    
    
    public function test_invalid_empty()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData([
            'start_month' => '',
        ]);
        
        $result = $inputFilter->isValid();
        $invalids = $inputFilter->getInvalidInput();
        
        $this->assertFalse($result);
        
        $this->assertArrayHasKey('start_month', $invalids);
        $this->assertArrayHasKey('start_year', $invalids);
        $this->assertArrayHasKey('end_month', $invalids);
        $this->assertArrayHasKey('end_year', $invalids);
    }
}
