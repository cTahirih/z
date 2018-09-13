<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * Interface: ResourcesProviderInterface
 * 
 * Provides a resource name and privileges for Zend ACL.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
interface ResourcesProviderInterface
{
    /**
     * Returns a Resource name.
     *
     * @return string
     * @since v1.0.0
     */
    public function getResourceName();
    
    
    /**
     * Returns a list of privileges.
     *
     * @return array
     * @since v1.0.0
     */
    public function getPrivileges();
    
    
    /**
     * Returns a list of resources and privileges as an array.
     *
     * @return array
     * @since v1.0.0
     */
    public function getResourcesAsArray();
}
