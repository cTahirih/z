<?php
namespace AdminAuth2\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;

/**
 * Zend Paginator adapter for Doctrine2 ORM.
 *
 * @see AdapterInterface
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DoctrinePaginatorAdapter implements AdapterInterface
{
    /**
     * @var Paginator
     */
    protected $paginator;
    
    /**
     * @var int
     */
    protected $count;
    
    
    /**
     * Constructor.
     *
     * @param Query $query
     * @return void
     */
    public function __construct(Query $query)
    {
        $paginator = new Paginator($query);
        $this->paginator = $paginator;
        $this->count = count($paginator);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->paginator->getIterator();
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->count;
    }
}
