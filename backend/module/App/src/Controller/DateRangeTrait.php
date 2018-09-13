<?php
namespace App\Controller;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait DateRangeTrait
{
    /**
     * @return bool
     */
    public function dateRangeIsValid()
    {
        $params = $this->getRequest()->getQuery();
        
        // Validate with InputFilter
        $dateRangeInputFilter = $this->dateRangeInputFilter;
        $dateRangeInputFilter->setData($params);
        
        if ($dateRangeInputFilter->isValid() == false) {
            return false;
        }
        
        // Validate with Specification
        $validDateRangeSpecification = $this->validDateRangeSpecification;
        
        if ($validDateRangeSpecification->isSatisfiedBy(
            $params['start_month'],
            $params['start_year'],
            $params['end_month'],
            $params['end_year']
        )) {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * Returns a sanitized array of the Date Range parameters.
     *
     * @return array
     */
    public function getDateRangeParameters()
    {
        $params  = $this->params()->fromQuery();
        
        return [
            'startMonth' => (int) $params['start_month'],
            'startYear'  => (int) $params['start_year'],
            'endMonth'   => (int) $params['end_month'],
            'endYear'    => (int) $params['end_year'],
        ];
    }
}
