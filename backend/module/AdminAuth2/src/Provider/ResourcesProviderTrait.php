<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * @package AdminAuth2
 * @version v1.1.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
trait ResourcesProviderTrait
{
    /**
     * @var string
     */
    protected $resourceName;
    
    
    /**
     * @return void
     * @since v1.1.0
     */
    public function initializeResourceProvider()
    {
        if (is_null($this->resourceName)) {
            throw new \RuntimeException('Undefined resource name in Provider.');
        }
    }
    
    
    /**
     * Returns a Resource name.
     *
     * @return string
     * @since v1.0.0
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }
    
    
    /**
     * Returns a list of privileges.
     *
     * @return array
     * @since v1.0.0
     */
    public function getPrivileges()
    {
        return [
            'list',
            'view',
            'add',
            'edit',
            'delete',
        ];
    }
    
    
    /**
     * Returns a list of resources and privileges as an array.
     *
     * @return array
     * @since v1.0.0
     */
    public function getResourcesAsArray()
    {
        return [$this->getResourceName() => $this->getPrivileges()];
    }
}
