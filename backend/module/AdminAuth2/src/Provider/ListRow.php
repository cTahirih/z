<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * A List Row object for getting the items and ID of the represented row in
 * a results table.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class ListRow
{
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var array|Traversable
     */
    protected $items;
    
    
    /**
     * Constructor
     *
     * @param mixed $id ID of the represented row
     * @param array|traversable $items
     * @return void
     * @since v1.0.0
     */
    public function __construct($id, $items)
    {
        $this->id    = $id;
        $this->items = $items;
    }
    
    
    /**
     * Get ID
     * 
     * @return int
     * @since v1.0.0
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * Get Items
     * 
     * @return array|Traversable
     * @since v1.0.0
     */
    public function getItems()
    {
        return $this->items;
    }
}
