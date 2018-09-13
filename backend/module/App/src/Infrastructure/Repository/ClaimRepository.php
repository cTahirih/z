<?php
namespace App\Infrastructure\Repository;

use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Dto\ClaimReportBestMonth;
use Carbon\Carbon;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ClaimRepository implements RepositoryWithInsertBatchInterface
{
    use DoInsertBatchTrait;
    use AverageByMonthReportTrait;
    
    /**
     * @var DbAdapter
     */
    protected $dbAdapter;
    
    /**
     * @var TableGateway
     */
    protected $tableGateway;
    
    
    /**
     * @return void
     */
    public function __construct(
        DbAdapter $dbAdapter
    ) {
        $this->dbAdapter    = $dbAdapter;
        $this->tableGateway = new TableGateway('claims', $this->dbAdapter);
    }
    
    
    /**
     * @param array $data
     * @return void
     */
    public function insertBatch(array $data)
    {
        $this->doInsertBatch($this->tableGateway, $data);
    }
    
    
    /**
     * @param DateRange $dateRange
     * @return array
     */
    public function getTotal(DateRange $dateRange)
    {
        $statement = $this->dbAdapter->createStatement('
            SELECT COUNT(order_id) AS cnt,
                   segment
              FROM claims,
                   customers
             WHERE claims.customer_id=customers.customer_id
               AND claims.created_at BETWEEN :start AND :end
          GROUP BY segment
        ',
        [
            ':start' => $dateRange->getStartDateAsString(),
            ':end' => $dateRange->getEndDateAsString(),
        ]);
        
        $result = $statement->execute();
        
        $gold     = 0;
        $platinum = 0;
        
        foreach ($result as $row) {
            if ($row['segment'] == 'platinum') {
                $platinum = (int) $row['cnt'];
                
            } elseif ($row['segment'] == 'gold') {
                $gold = (int) $row['cnt'];
            }
        }
        
        return [
            'all'      => $gold + $platinum,
            'gold'     => $gold,
            'platinum' => $platinum,
        ];
    }
    
    
    /**
     * @param DateRange $dateRange
     * @return array
     */
    public function getAverageByUser(DateRange $dateRange)
    {
        $data = [];
        
        foreach (['all', 'gold', 'platinum'] as $segment) {
            $params = [
                ':start' => $dateRange->getStartDateAsString(),
                ':end' => $dateRange->getEndDateAsString(),
            ];
            
            if ($segment != 'all') {
                $params[':segment'] = $segment;
            }
            
            $statement = $this->dbAdapter->createStatement('
                SELECT ROUND(AVG(b.cnt)) AS average
                  FROM (
                      SELECT customers.customer_id,
                             COUNT(*) AS cnt,
                             segment
                       FROM claims,
                            customers
                      WHERE claims.customer_id = customers.customer_id
                        AND claims.created_at BETWEEN :start AND :end
                   GROUP BY customers.customer_id,
                            segment
                  ) b
            ' . ($segment == 'all' ? '' : 'WHERE b.segment=:segment')
            ,
            $params);
            
            $result = $statement->execute();
            
            $data[$segment] = (int) $result->current()['average'];
        }
        
        return $data;
    }
    
    
    /**
     * @param DateRange $dateRange
     * @return void
     */
    public function getQuantityByMonth(DateRange $dateRange)
    {
        // Fetch for Totals
        $statement = $this->dbAdapter->createStatement('
            SELECT COUNT(*) AS total,
                   YEAR(claims.created_at) AS `year`,
                   MONTH(claims.created_at) AS `month`,
                   segment
              FROM claims,
                   customers
             WHERE claims.customer_id = customers.customer_id
               AND claims.created_at BETWEEN :start AND :end
          GROUP BY YEAR(claims.created_at),
                   MONTH(claims.created_at),
                   segment
          ORDER BY claims.created_at
        ',
        [
            ':start' => $dateRange->getStartDateAsString(),
            ':end' => $dateRange->getEndDateAsString(),
        ]);
        
        $result = $statement->execute();
        $data   = $this->getEmptyQuantityTable($dateRange);
        $data   = $this->processQuantityTotals($data, $result, $dateRange);
        
        // Fetch for Averages
        $statement = $this->dbAdapter->createStatement('
            SELECT ROUND(AVG(b.cnt)) AS average,
                   year,
                   month,
                   segment
             FROM (
                 SELECT COUNT(*) AS cnt,
                        YEAR(claims.created_at) AS year,
                        MONTH(claims.created_at) AS month,
                        DAY(claims.created_at) AS day,
                        segment
                   FROM claims,
                        customers
                  WHERE claims.customer_id = customers.customer_id
                    AND claims.created_at BETWEEN :start AND :end
               GROUP BY DATE(claims.created_at),
                        segment
             ) b
         GROUP BY b.year,
                  b.month,
                  b.segment
        ',
        [
            ':start' => $dateRange->getStartDateAsString(),
            ':end' => $dateRange->getEndDateAsString(),
        ]);
        
        $result = $statement->execute();
        $data   = $this->processQuantityAverages($data, $result, $dateRange);
        
        return $this->processQuantityTable($data);
    }
    
    
    /**
     * @param DateRange $dateRange
     * @return void
     */
    public function getAcquisitionAverageByUser(DateRange $dateRange)
    {
        $data = [
            'all'      => 0,
            'gold'     => 0,
            'platinum' => 0,
        ];
        
        foreach (['all', 'gold', 'platinum'] as $segment) {
            $params = [
                ':start' => $dateRange->getStartDateAsString(),
                ':end' => $dateRange->getEndDateAsString(),
            ];
            
            if ($segment != 'all') {
                $params['segment'] = $segment;
            }
            
            $statement = $this->dbAdapter->createStatement('
                SELECT ROUND(AVG(b.claim_acquisition_average)) AS average
                  FROM (
                      SELECT claim_acquisition_average
                        FROM claims,
                             customers
                       WHERE claims.customer_id = customers.customer_id
             ' . ($segment == 'all' ? '' : 'AND customers.segment = :segment') . '
                         AND claims.created_at BETWEEN :start AND :end
                  ) b
            ',
            $params);
            
            $result = $statement->execute();
            $data[$segment] = $result->current()['average'];
        }
        
        return $data;
    }
    
    
    
    
    /**
     * Calculates the acquisition average for every Customer in the Claims
     * table.
     *
     * We will only consider the users/customers that are both in the
     * Claims and Customers tables.
     *
     * The acquisition average is an integer, as in every "3 months". It's the
     * time average of the Customer's Claims. It is calculated this way; for
     * every Customer:
     *
     * - Get every Month in which at least one Claim was registered. We don't
     *   care about the amount of Claims, just the Month in which the
     *   transaction or transactions occurred. Sort by date.
     * - Get the max and minimum date of creation date (the first and last rows,
     *   that is.
     * - Calculate the amount of months between these two date ranges. For
     *   example, there's 7 months between June 2017 and December 2017.
     * - Calculate the average thus:
     *
     *       (A / B) * C
     *
     *   A = Count of months with Claims 
     *   B = Count of months in period  
     *   C = Count of months with no Claims
     *
     * @return void
     */
    public function setUsersAcquisitionAverage()
    {
        $this->customersTg = new TableGateway('customers', $this->dbAdapter);
        
        // Get the list of Customers
        $statement = $this->dbAdapter->createStatement('
            SELECT customers.customer_id
              FROM claims,
                   customers
             WHERE claims.customer_id = customers.customer_id
        ');
        
        $customers = $statement->execute();
        
        foreach ($customers as $customer) {
            $customerId = $customer['customer_id'];
            
            // Get the Customer's Claims
            $statement = $this->dbAdapter->createStatement('
                SELECT YEAR(claims.created_at) AS year,
                       MONTH(claims.created_at) AS month
                  FROM claims,
                       customers
                 WHERE claims.customer_id = customers.customer_id
                   AND claims.customer_id = :customerId
              GROUP BY YEAR(claims.created_at),
                       MONTH(claims.created_at)
              ORDER BY YEAR(claims.created_at),
                       MONTH(claims.created_at)
            ', compact('customerId'));
            
            $result = $statement->execute();
            
            $data = iterator_to_array($result);
            $monthsWithCodesCount = count($data);
            
            // If <= 1, save immediately as 1 and break the loop.
            // I SAID WE BREAK THE LOOP IN HERE.
            if ($monthsWithCodesCount <= 1) {
                $this->setCustomerClaimAcquisitionAverage($customerId, 1);
                continue;
            }
            
            $row        = reset($data);
            $startMonth = $row['month'];
            $startYear  = $row['year'];
            
            $row      = end($data);
            $endMonth = $row['month'];
            $endYear  = $row['year'];
            
            $totalMonthsCount = $this->getMonthsCount(
                $startMonth,
                $startYear,
                $endMonth,
                $endYear
            );
            
            $monthsWithoutCodesCount = $totalMonthsCount - $monthsWithCodesCount;
            
            // Here's the gist
            $average = round(($monthsWithCodesCount / $totalMonthsCount) * $monthsWithoutCodesCount);
            
            if ($average == 0) {
                $average = 1;
            }
            
            $this->setCustomerClaimAcquisitionAverage($customerId, $average);
        }
    }
    
    
    /**
     * @param int $startMonth
     * @param int $startYear
     * @param int $endMonth
     * @param int $endYear
     * @return integer
     */
    public function getMonthsCount(int $startMonth, int $startYear, int $endMonth, int $endYear)
    {
        $startDate = Carbon::createFromDate($startYear, $startMonth, 1);
        $endDate   = Carbon::createFromDate($endYear, $endMonth, 1);
        
        return $startDate->diffInMonths($endDate) + 1;
    }
    
    
    /**
     * @param int $customerId
     * @param int $value
     * @return void
     */
    public function setCustomerClaimAcquisitionAverage($customerId, $value)
    {
        $this->customersTg->update(
            ['claim_acquisition_average' => $value],
            ['customer_id' => $customerId]
        );
    }
}
