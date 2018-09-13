<?php
namespace App\Infrastructure\Repository;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class UserRepository implements RepositoryWithInsertBatchInterface
{
    use DoInsertBatchTrait;
    
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
        $this->tableGateway = new TableGateway('users', $this->dbAdapter);
    }
    
    
    /**
     * @param array $data
     * @return void
     */
    public function insertBatch(array $data)
    {
        // Set segment field according to User's points balance
        foreach ($data as $k => $v) {
            $data[$k]['segment'] = $this->getSegmentByPointBalance($v['points_balance']);
        }
        
        $this->doInsertBatch($this->tableGateway, $data);
    }
    
    
    /**
     * Returns the segment name according to the points balance specified.
     *
     * @param int $balance
     * @return string
     */
    public function getSegmentByPointBalance(int $balance)
    {
        if ($balance >= 1500) {
            return 'platinum';
        }
        
        return 'gold';
    }
}
