<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider\Doctrine;

use AdminAuth2\Adapter\DoctrinePaginatorAdapter;
use AdminAuth2\Provider\ListRow;
use AdminAuth2\Provider\ListWithSortProviderTrait;
use AdminAuth2\Provider\ProviderField;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Iterator;
use Zend\Paginator\Paginator;

/**
 * A Doctrine Implementation of the ListProviderInterface
 *
 * @package AdminAuth2
 * @version v2.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
trait DoctrineListProviderTrait
{
    /**
     * @var array
     */
    protected $fields;
    
    /**
     * @var Iterator
     */
    protected $iterator;
    
    /**
     * @var Paginator
     */
    protected $paginator;
    
    /**
     * @var int
     */
    protected $itemCountPerPage = 20;
    
    /**
     * @var Query
     */
    protected $query;
    
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;
    
    
    /**
     * Prepares the List provider.
     *
     * @return self
     * @since v1.0.0
     */
    public function prepareList()
    {
        $this->query    = $this->getListQuery();
        $this->iterator = $this->getPaginator()->getIterator();
        
        return $this;
    }
    
    
    /**
     * Returns `ASC` or `DESC` according to the sort direction set.
     *
     * @return string
     * @since v1.0.0
     */
    public function getListQuerySortDirection()
    {
        $direction = null;
        
        if ($this instanceof ListWithSortProviderTrait) {
            $direction = $this->getListSortDirection();
        }
        
        if (is_null($direction)) {
            return 'DESC';
        }
        
        return strtoupper($direction);
    }
    
    
    /**
     * Get the Doctrine\ORM\QueryBuilder used to query the list.
     *
     * @return QueryBuilder
     * @since v2.0.0
     */
    public function getListQueryBuilder()
    {
        if (is_null($this->queryBuilder)) {
            
            $sortProperty = null;
            
            if ($this instanceof ListWithSortProviderTrait) {
                $sortProperty  = $this->getListSortProperty();
            }
            
            if (is_null($sortProperty)) {
                $sortProperty = 'id';
            }
            $sortField = sprintf('r.%s', $sortProperty);
            
            $sortDirection = $this->getListQuerySortDirection();
            
            $this->queryBuilder = $this->entityManager->createQueryBuilder()
                ->select('r')
                ->from($this->entityClass, 'r')
                ->orderBy($sortField, $sortDirection)
                ->setFirstResult(($this->pageNumber - 1) * $this->itemCountPerPage)
                ->setMaxResults($this->itemCountPerPage);
        }
        
        return $this->queryBuilder;
    }
    
    
    /**
     * @param QueryBuilder $qb
     * @return void
     * @since v2.0.0
     */
    public function setListQueryBuilder(QueryBuilder $qb)
    {
        $this->queryBuilder = $qb;
    }
    
    
    /**
     * Get the Doctrine\ORM\Query used to fetch results.
     *
     * @return Query
     * @since v1.0.0
     */
    public function getListQuery()
    {
        return $this->getListQueryBuilder()->getQuery();
    }
    
    
    /**
     * Set item count per page for pagination.
     *
     * @param int $itemCountPerPage
     * @return self
     * @since v1.0.0
     */
    public function setItemCountPerPage($itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;
        return $this;
    }
    
    
    /**
     * {@inheritDoc}
     */
    abstract public function getListFields();
    
    
    /**
     * {@inheritDoc}
     */
    public function getListHeaders()
    {
        return array_keys($this->getListFields());
    }
    
    
    /**
     * Returns itself, so the iterator functions can do their magic.
     *
     * @return self
     * @since v1.0.0
     */
    public function getListRows()
    {
        return $this;
    }
    
    
    /**
     * Returns a Zend\Paginator\Paginator object.
     *
     * @return Paginator
     * @since v1.0.0
     */
    public function getPaginator()
    {
        if (is_null($this->paginator)) {
            $doctrineAdapter = new DoctrinePaginatorAdapter($this->query);
            $this->paginator = new Paginator($doctrineAdapter);
            $this->paginator->setCurrentPageNumber($this->pageNumber);
            $this->paginator->setItemCountPerPage($this->itemCountPerPage);
        }
        return $this->paginator;
    }
    
    
    /**
     * Returns a ListRow by iterating a Doctrine result. It will invoke the
     * proper getter defined in the $fields property and return it as a
     * ProviderField object.
     *
     * @return ListRow
     * @since v1.0.0
     */
    public function current()
    {
        $r = $this->iterator->current();
        
        $items = [];
        foreach ($this->getListFields() as $name => $method) {
            $items[] = new ProviderField($name, [$r, $method]);
        }
        
        return new ListRow($r->getId(), $items);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        return $this->iterator->rewind();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->iterator->key();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function next()
    {
        return $this->iterator->next();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->iterator->valid();
    }
}
