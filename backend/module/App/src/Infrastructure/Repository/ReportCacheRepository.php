<?php
namespace App\Infrastructure\Repository;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheRepository
{
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
        $this->tableGateway = new TableGateway('reports_cache', $this->dbAdapter);
    }
    
    
    /**
     * @param string $report
     * @param string $parameters
     * @param mixed $content
     * @return void
     */
    public function save(string $report, string $parameters, $content)
    {
        $this->tableGateway->insert([
            'report'     => $report,
            'parameters' => $parameters,
            'content'    => serialize($content),
        ]);
    }
    
    
    /**
     * @param string $report
     * @param string $parameters
     * @return mixed
     */
    public function get(string $report, string $parameters)
    {
        $result = $this->tableGateway->select(function ($select) use ($report, $parameters) {
            $select
                ->where([
                    'report'     => $report,
                    'parameters' => $parameters,
                ])
                ->order('created_at DESC');
        });
        
        if ($result->count() == 0) {
            return null;
        }
        
        return unserialize($result->current()->content);
    }
}
