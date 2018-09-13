<?php
namespace App\Infrastructure\Repository;

use App\Domain\ValueObject\DateRange;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CapsuleRepository implements RepositoryWithInsertBatchInterface
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
        $this->tableGateway = new TableGateway('capsules', $this->dbAdapter);
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
            SELECT COUNT(*) AS cnt,
                   segment
              FROM capsules
             WHERE created_at BETWEEN :start AND :end
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
                      SELECT customer_id,
                             COUNT(*) AS cnt,
                             segment
                       FROM capsules
                      WHERE created_at BETWEEN :start AND :end
                   GROUP BY customer_id,
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
     * @return array
     */
    public function getQuantityByMonth(DateRange $dateRange)
    {
        // Fetch for Totals
        $statement = $this->dbAdapter->createStatement('
            SELECT COUNT(*) AS total,
                   YEAR(created_at) AS `year`,
                   MONTH(created_at) AS `month`,
                   segment
              FROM capsules
             WHERE created_at BETWEEN :start AND :end
          GROUP BY YEAR(created_at),
                   MONTH(created_at),
                   segment
          ORDER BY created_at
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
                        YEAR(created_at) AS year,
                        MONTH(created_at) AS month,
                        DAY(created_at) AS day,
                        segment
                   FROM capsules
                  WHERE created_at BETWEEN :start AND :end
               GROUP BY DATE(created_at),
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
}
