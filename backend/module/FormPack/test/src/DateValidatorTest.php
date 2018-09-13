<?php
namespace FormPack\Test;

use BaseTest\Helpers;
use DateTime;
use FormPack\Validator\DateValidator;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Validator\AbstractValidator;

/**
 * @see AbstractHttpControllerTestCase
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DateValidatorTest extends AbstractHttpControllerTestCase
{
    use Helpers;
    
    /**
     * @var boolean
     */
    protected $traceError = true;
    
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    /**
     * @return DateValidator
     */
    public function getValidator()
    {
        return $this->getServiceManager()->get('ValidatorManager')->get(DateValidator::class);
    }
    
    
    public function test_instantiation()
    {
        $validator = $this->getValidator();
        $this->assertInstanceOf(AbstractValidator::class, $validator);
        $this->assertInstanceOf(DateValidator::class, $validator);
    }
    
    
    public function test_valid()
    {
        $validator = $this->getValidator();
        
        $dates = [
            '2018-12-31',
            '1990-01-01',
            '1978-11-05',
        ];
        
        foreach ($dates as $date) {
            $this->assertTrue($validator->isValid($date));
        }
    }
    
    
    public function test_valid_with_other_format()
    {
        $format = 'd/m/Y';
        $date   = '31/01/1987';
        
        $validator = new DateValidator([
            'format' => $format,
        ]);
        
        $this->assertTrue($validator->isValid($date));
    }
    
    
    public function test_invalid_with_other_format()
    {
        $format = 'd/m/Y';
        $date   = '31-01-1987';
        
        $validator = new DateValidator([
            'format' => $format,
        ]);
        
        $this->assertFalse($validator->isValid($date));
    }
    
    
    public function test_max_date()
    {
        $maxDate     = new DateTime('1990-01-10');
        $validDate   = '1990-01-09';
        $invalidDate = '1990-01-11';
        
        $validator = new DateValidator([
            'maxDate' => $maxDate,
        ]);
        
        $this->assertTrue($validator->isValid($validDate));
        $this->assertFalse($validator->isValid($invalidDate));
        
        $error = current(array_keys($validator->getMessages()));
        $this->assertEquals(DateValidator::GREATER_THAN_MAX_DATE, $error);
    }
    
    
    public function test_min_date()
    {
        $minDate     = new DateTime('1990-01-10');
        $validDate   = '1990-01-11';
        $invalidDate = '1990-01-09';
        
        $validator = new DateValidator([
            'minDate' => $minDate,
        ]);
        
        $this->assertTrue($validator->isValid($validDate));
        $this->assertFalse($validator->isValid($invalidDate));
        
        $error = current(array_keys($validator->getMessages()));
        $this->assertEquals(DateValidator::LESS_THAN_MIN_DATE, $error);
    }
}
