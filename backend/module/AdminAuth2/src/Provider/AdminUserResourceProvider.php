<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * Provides the Resources for AdminUserProvider. This class is necessary
 * because ResourceService needs to fetch AdminUserProvider's resources, but
 * ResourceService itself is a dependency of AdminUserProvider, causing a
 * circular dependency.
 *
 * @see AdminUserProvider
 * @see ResourcesProviderInterface
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class AdminUserResourceProvider implements ResourcesProviderInterface
{
    use ResourcesProviderTrait;
    
    public function __construct()
    {
        $this->resourceName = 'admin_users';
        $this->initializeResourceProvider();
    }
}
