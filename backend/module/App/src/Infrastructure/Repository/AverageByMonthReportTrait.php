<?php
namespace App\Infrastructure\Repository;

use App\Domain\ValueObject\DateRange;
use Iterator;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait AveragebyMonthReportTrait
{
    /**
     * Returns a zeroed quantity table for the given date range. This is
     * because a query result in a date range can have missing months
     * on no rows. This table will later be populated.
     *
     * It's a multidimensional array in the form of`[year][month][segment] = 0`
     * for every year and month.
     *
     * @param DateRange $dateRange
     * @return array
     */
    public function getEmptyQuantityTable(DateRange $dateRange)
    {
        $startDate = $dateRange->getStartDate()->copy()->startOfDay();
        $endDate   = $dateRange->getEndDate()->copy()->startOfDay();
        $row       = [
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
        
        // If the range is one month, then build it straight away.
        if ($startDate->eq($endDate)) {
            return [
                $startDate->year => [
                    $startDate->month => $row,
                ],
            ];
        }
        
        $table = [];
        $date  = $startDate;
        
        while ($date <= $endDate) {
            $year = $date->year;
            $month = $date->month;
            
            if (!array_key_exists($year, $table)) {
                $table[$year] = [];
            }
            
            if (!array_key_exists($month, $table[$year])) {
                $table[$year][$month] = $row;
            }
            
            $date = $date->addDay();
        }
        
        return $table;
    }
    
    
    /**
     * @param array $data
     * @param Iterable $result
     * @param DateRange $dateRange
     * @return array
     */
    public function processQuantityTotals(array $data, Iterator $result, DateRange $dateRange)
    {
        foreach ($result as $row) {
            $year    = (int) $row['year'];
            $month   = (int) $row['month'];
            $total   = (int) $row['total'];
            $segment = $row['segment'];
            
            $data[$year][$month]['total'][$segment] = $total;
        }
        
        // Calculate count for `all` index
        foreach ($data as $year => $months) {
            foreach ($months as $month => $count) {
                $data[$year][$month]['total']['all'] =
                    $count['total']['gold'] + $count['total']['platinum'];
            }
        }
        
        return $data;
    }
    
    
    /**
     * @param array $data
     * @param Iterable $result
     * @param DateRange $dateRange
     * @return array
     */
    public function processQuantityAverages(array $data, Iterator $result, DateRange $dateRange)
    {
        foreach ($result as $row) {
            $year    = (int) $row['year'];
            $month   = (int) $row['month'];
            $average = (int) $row['average'];
            $segment = $row['segment'];
            
            $data[$year][$month]['average'][$segment] = $average;
        }
        
        return $data;
    }
    
    
    /**
     * @param array $data
     * @return array
     */
    public function processQuantityTable(array $data)
    {
        $result = [];
        
        foreach ($data as $year => $months) {
            foreach ($months as $month => $row) {
                $result[] = [
                    'year'    => $year,
                    'month'   => $month,
                    'total'   => $row['total'],
                    'average' => $row['average'],
                ];
            }
        }
        
        return $result;
    }
}
