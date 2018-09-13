<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use AdminAuth2\Exception\RuntimeException;

/**
 * Data Object for a Provider's field.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class ProviderField
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string|callable
     */
    protected $value;
    
    /**
     * @var array
     */
    protected $fields;
    
    
    /**
     * Constructor
     *
     * @param string $name
     * @param string|callable $value
     * @return ProviderField
     * @since v1.0.0
     */
    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
        return $this;
    }
    
    
    /**
     * Get Name
     * 
     * @return string
     * @since v1.0.0
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    /**
     * Set Name
     * 
     * @param string $name
     * @return ProviderField
     * @since v1.0.0
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    
    /**
     * Get Value. If a callable, calls it and returns its result.
     * 
     * @return mixed
     * @since v1.0.0
     */
    public function getValue()
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        
        return $this->value;
    }
    
    
    /**
     * Set Value
     * 
     * @param string|callable $value
     * @return ProviderField
     * @throws RuntimeException
     * @since v1.0.0
     */
    public function setValue($value)
    {
        if (!is_string($value) && !is_callable($value)) {
            throw new RuntimeException('Invalid value for ' . $this->getName() . ' ProviderField, should be a string or callable.');
        }
        
        $this->value = $value;
        return $this;
    }
    
    
    /**
     * Return value as it is, a string or a callable, not invoking the latter.
     *
     * @return string|callable
     * @since v1.0.0
     */
    public function getRawValue()
    {
        return $this->value;
    }
    
    
    /**
     * Change a value callable's Object method.
     *
     * @param string $method
     * @return ProviderField
     * @throws RuntimeException
     * @since v1.0.0
     */
    public function setMethod($method)
    {
        $value = $this->getRawValue();
        
        if (is_callable($value) && is_array($value)) {
            $value[1] = $method;
            $this->setValue($value);
            return $this;
        }
        
        throw new RuntimeException('Can\'t assign a method to a non-callable value.');
    }
}
