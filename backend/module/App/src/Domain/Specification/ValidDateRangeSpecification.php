<?php
namespace App\Domain\Specification;

use Carbon\Carbon;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class ValidDateRangeSpecification implements SpecificationInterface
{
    /**
     * @param integer $startMonth
     * @param integer $startYear
     * @param integer $endMonth
     * @param integer $endYear
     * @return bool
     */
    public function isSatisfiedBy($startMonth, $startYear, $endMonth, $endYear)
    {
        try {
            Assert::integerish($startMonth);
            Assert::integerish($startYear);
            Assert::integerish($endMonth);
            Assert::integerish($endYear);
            
            Assert::range($startMonth, 1, 12);
            Assert::range($endMonth, 1, 12);
            
            Assert::range($startYear, 2015, date('Y'));
            Assert::range($endYear, 2015, date('Y'));
            
        } catch (InvalidArgumentException $e) {
            return false;
        }
        
        // Build a Carbon date to validate if end date is greater than start date.
        $startDate = Carbon::createMidnightDate($startYear, $startMonth, 1);
        $endDate   = Carbon::createFromDate($endYear, $endMonth, 1)->endOfMonth();
        
        if ($startDate->gt($endDate)) {
           return false;
        }
        
        return true;
    }
}
