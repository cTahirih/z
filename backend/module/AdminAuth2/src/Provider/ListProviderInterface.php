<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * Interface: ListProviderInterface
 * 
 * @see \Iterator
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 *
 */
interface ListProviderInterface
{
    /**
     * Prepares the object.
     *
     * @return void
     * @since v1.0.0
     */
    public function prepareList();
    
    
    /**
     * Returns a list of the List's fields.
     *
     * @return array|Traversable
     * @since v1.0.0
     */
    public function getListFields();
    
    
    /**
     * Returns an array of Header names.
     *
     * @return array|Traversable
     * @since v1.0.0
     */
    public function getListHeaders();
    
    
    /**
     * Returns an Iterable object with the List's rows.
     *
     * @return \Iterable
     * @since v1.0.0
     */
    public function getListRows();
    
    
    /**
     * @return integer
     * @since v1.0.0
     */
    public function getCurrentPage();
    
    
    /**
     * Set current page for pagination.
     *
     * @param integer $pageNumber
     * @return self
     * @since v1.0.0
     */
    public function setCurrentPage($pageNumber);
}
