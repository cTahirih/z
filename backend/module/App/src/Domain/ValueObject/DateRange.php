<?php
namespace App\Domain\ValueObject;

use App\Domain\Specification\ValidDateRangeSpecification;
use Carbon\Carbon;
use InvalidArgumentException;

class DateRange
{
    /**
     * @var Carbon
     */
    protected $startDate;
    
    /**
     * @var integer
     */
    protected $endDate;
    
    
    /**
     * @param integer $startMonth
     * @param integer $startYear
     * @param integer $endMonth
     * @param integer $endYear
     * @return void
     */
    public function __construct(
        $startMonth,
        $startYear,
        $endMonth,
        $endYear
    ) {
        $specification = new ValidDateRangeSpecification();
        
        if ($specification->isSatisfiedBy($startMonth, $startYear, $endMonth, $endYear) == false) {
            throw new InvalidArgumentException(sprintf('Invalid date range specification. Received: %s/%s - %s/%s', $startMonth, $startYear, $endMonth, $endYear));
        }
        
        $this->startDate = Carbon::createMidnightDate($startYear, $startMonth, 1);
        $this->endDate   = Carbon::createFromDate($endYear, $endMonth, 1)->endOfMonth();
    }
    
    
    /**
     * @return integer
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    
    /**
     * @return integer
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    
    /**
     * @return string
     */
    public function getStartDateAsString()
    {
        return $this->startDate->format('Y-m-d H:i:s');
    }
    
    
    /**
     * @return string
     */
    public function getEndDateAsString()
    {
        return $this->endDate->format('Y-m-d H:i:s');
    }
}
