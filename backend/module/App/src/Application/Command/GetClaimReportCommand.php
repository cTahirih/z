<?php
namespace App\Application\Command;

use DDD\Command\Command;
use RuntimeException;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetClaimReportCommand implements Command
{
    /**
     * @var string
     */
    public $section = 'claim';
    
    /**
     * @var string
     */
    public $report;
    
    /**
     * @var array
     */
    public $parameters;
    
    
    /**
     * @param string $report
     * @param array $parameters
     * @return void
     */
    public function __construct(
        string $report,
        array $parameters
    ) {
        $this->dateRangeParameters = [
            'startMonth',
            'startYear',
            'endMonth',
            'endYear',
        ];
        
        // Reports mapping
        // Name => Parameters expected
        $this->reportsMapping = [
            'Total'                    => $this->dateRangeParameters,
            'AverageByUser'            => $this->dateRangeParameters,
            'QuantityByMonth'          => $this->dateRangeParameters,
            'AcquisitionAverageByUser' => $this->dateRangeParameters,
        ];
        
        $this->checkIfReportisValid($report);
        $this->checkIfParametersAreValid($report, $parameters);
        
        $this->report = $report;
        $this->parameters = $parameters;
    }
    
    
    /**
     * @param string $report
     * @return void
     */
    public function checkIfReportIsValid(string $report)
    {
        if (!array_key_exists($report, $this->reportsMapping)) {
            throw new RuntimeException(sprintf('Invalid report "%s" requested.', $report));
        }
    }
    
    
    /**
     * @param array $parameters
     * @return void
     */
    public function checkIfParametersAreValid(string $report, array $parameters)
    {
        foreach ($this->reportsMapping[$report] as $parameter) {
            if (!array_key_exists($parameter, $parameters)) {
                throw new RuntimeException(sprintf('Undefined required parameter "%s" for report "%s".', $parameter, $report));
            }
            
            $this->$parameter = $parameters[$parameter];
        }
    }
}
