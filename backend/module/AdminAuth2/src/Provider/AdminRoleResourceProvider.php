<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * Provides the Resources for AdminRoleProvider. This class is necessary
 * because ResourceService needs to fetch AdminRoleProvider's resources, but
 * ResourceService itself is a dependency of AdminRoleProvider, causing a
 * circular dependency.
 *
 * @see AdminRoleProvider
 * @see ResourcesProviderInterface
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class AdminRoleResourceProvider implements ResourcesProviderInterface
{
    use ResourcesProviderTrait;
    
    public function __construct()
    {
        $this->resourceName = 'admin_roles';
        $this->initializeResourceProvider();
    }
}
