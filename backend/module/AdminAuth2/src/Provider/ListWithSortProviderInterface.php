<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * An interface for a List Provider that also handles sorted fields.
 * 
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 *
 */
interface ListWithSortProviderInterface
{
    /**
     * @return string|null
     * @since v1.0.0
     */
    public function getListSortField();
    
    
    /**
     * @param string|null $field
     * @return self
     * @since v1.0.0
     */
    public function setListSortField($field);
    
    
    /**
     * @return string|null Either `asc` or `desc`.
     * @since v1.0.0
     */
    public function getListSortDirection();
    
    
    /**
     * @param string|null $direction Either `asc` or `desc`.
     * @return void
     * @since v1.0.0
     */
    public function setListSortDirection($direction);
}
