<?php
namespace App\Infrastructure\Repository;

use Zend\Db\Adapter\Adapter as DbAdapter;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportRepository
{
    /**
     * @var DbAdapter
     */
    protected $dbAdapter;
    
    
    /**
     * @return void
     */
    public function __construct(
        DbAdapter $dbAdapter
    ) {
        $this->dbAdapter = $dbAdapter;
    }
}
