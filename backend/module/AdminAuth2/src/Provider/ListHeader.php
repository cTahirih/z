<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use Webmozart\Assert\Assert;
use Zend\Stdlib\ArrayUtils;

/**
 * A class representing a List Header.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
class ListHeader
{
    /**
     * @var string
     */
    protected $title;
    
    /**
     * @var string
     */
    protected $slug;
    
    /**
     * @var array
     */
    protected $attributes;
    
    /**
     * @var string
     */
    protected $property;
    
    /**
     * @var boolean
     */
    protected $isSortable;
    
    /**
     * @var string Either `asc` (ascending) or `desc` (descending)
     */
    protected $sortDirection;
    
    
    
    /**
     * @param string $title
     * @param string $slug
     * @param array $attributes
     * @return void
     * @since v1.0.0
     */
    public function __construct(
        $title,
        $slug,
        $attributes = []
    ) {
        $this->title   = $title;
        $this->slug    = $slug;
        
        /**
         * - property: Name of property or SQL field that will internally be
         *   used to sort by. Default is set the same as the slug.
         * - isSortable: Boolean if the field is sortable or not.
         * - sortDirection: `asc` or `desc` for ascending or descending,
         *   respectively.
         */
        $defaultAttributes = [
            'property'      => $slug,
            'isSortable'    => true,
            'sortDirection' => null,
        ];
        
        $this->attributes = ArrayUtils::merge($defaultAttributes, $attributes);
    }
    
    
    /**
     * @return string
     * @since v1.0.0
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    
    /**
     * @return string
     * @since v1.0.0
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    
    /**
     * @param string $name
     * @return mixed
     * @since v1.0.0
     */
    public function getAttribute($name)
    {
         if (array_key_exists($name, $this->attributes)) {
             return $this->attributes[$name];
         }
         return null;
    }
    
    
    /**
     * @param string $name
     * @param mixed $value
     * @return self
     * @since v1.0.0
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }
    
    
    /**
     * @return string
     * @since v1.0.0
     */
    public function getProperty()
    {
        return $this->getAttribute('property');
    }
    
    
    /**
     * @return boolean
     * @since v1.0.0
     */
    public function isSortable()
    {
        return $this->getAttribute('isSortable');
    }
    
    
    public function getSortDirection()
    {
        return $this->getAttribute('sortDirection');
    }
}
