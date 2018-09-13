<?php
namespace FormPack\Validator;

use DateTime;
use Zend\Validator\AbstractValidator;

/**
 * @package Website
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DateValidator extends AbstractValidator
{
    const INVALID               = 'invalid';
    const GREATER_THAN_MAX_DATE = 'greaterThanMax';
    const LESS_THAN_MIN_DATE    = 'lessThanMin';
    
    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID               => 'La fecha no es válida',
        self::GREATER_THAN_MAX_DATE => 'La fecha es mayor a %maxDateString%',
        self::LESS_THAN_MIN_DATE    => 'La fecha es menor a %minDateString%',
    ];
    
    /**
     * @var array
     */
    protected $messageVariables = array(
        'maxDateString' => 'maxDateString',
        'minDateString' => 'minDateString',
    );
    
    /**
     * @var array
     */
    protected $options = [
        'format'  => 'Y-m-d',
        'maxDate' => null,
        'minDate' => null,
    ];
    
    /**
     * @var string
     */
    protected $maxDateString = '';
    
    /**
     * @var string
     */
    protected $minDateString = '';
    
    
    /**
     * {@inheritDoc}
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $format = $this->getOption('format');
        
        $maxDate = $this->getOption('maxDate');
        if ($maxDate instanceof DateTime) {
            $this->maxDateString = $maxDate->format($format);
        }
        
        $minDate = $this->getOption('minDate');
        if ($minDate instanceof DateTime) {
            $this->minDateString = $minDate->format($format);
        }
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);
        
        $format = $this->getOption('format');
        $date   = DateTime::createFromFormat($format, $value);
        
        if ($date === false) {
            $this->error(self::INVALID);
            return false;
        }
        
        // Invalid dates can show up as warnings (ie. "2007-02-99")
        // and still return a DateTime object.
        $errors = DateTime::getLastErrors();
        if ($errors['warning_count'] > 0) {
            $this->error(self::INVALID);
            return false;
        }
        
        // If maximum date has been provided, validate
        if ($this->getOption('maxDate') instanceof DateTime) {
            $maxDate = $this->getOption('maxDate');
            
            if ($date > $maxDate) {
                $this->error(self::GREATER_THAN_MAX_DATE);
                return false;
            }
        }
        
        // If minimum date has been provided, validate
        if ($this->getOption('minDate') instanceof DateTime) {
            $minDate = $this->getOption('minDate');
            
            if ($date < $minDate) {
                $this->error(self::LESS_THAN_MIN_DATE);
                return false;
            }
        }
        return true;
    }
}
