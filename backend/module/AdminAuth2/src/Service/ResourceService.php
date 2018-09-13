<?php
namespace AdminAuth2\Service;

use AdminAuth2\Provider\ResourcesProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ResourceService
{
    /**
     * @var array
     */
    protected $config;
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;
    
    /**
     * @var array
     */
    protected $resources;
    
    
    /**
     * @param mixed $config
     * @param ServiceLocatorInterface $serviceManager
     * @return void
     */
    public function __construct(
        $config,
        ServiceLocatorInterface $serviceManager
    ) {
        $this->config         = $config;
        $this->serviceManager = $serviceManager;
        $this->resources      = [];
        
        // Load up all declared Providers in 'resources' config
        if (isset($config['adminauth2']['resources'])) {
            foreach ($config['adminauth2']['resources'] as $providerName) {
                $provider = $this->serviceManager->get($providerName);
                
                if (!in_array($provider, $this->resources)) {
                    if (!$provider instanceof ResourcesProviderInterface) {
                        throw new \RuntimeException("Resource $providerName is not a ResourcesProviderInterface instance");
                    }
                    
                    $this->resources[] = $provider;
                }
            }
        }
        
        // Load up all Providers in 'providers' config. The difference is that
        // it will not complain if the class does not implement
        // ResourcesProviderInterface, but ignore it silently.
        if (isset($config['adminauth2']['providers'])) {
            // Do not consider AdminUserProvider and AdminRoleProvider,
            // otherwise a circular reference is triggered.
            $providersList = $config['adminauth2']['providers'];
            $key = array_search('AdminAuth2\Provider\AdminUserProvider', $providersList, true);
            unset($providersList[$key]);
            $key= array_search('AdminAuth2\Provider\AdminRoleProvider', $providersList, true);
            unset($providersList[$key]);
            
            foreach ($providersList as $providerName) {
                $provider = $this->serviceManager->get($providerName);
                
                if (!in_array($provider, $this->resources)) {
                    if ($provider instanceof ResourcesProviderInterface) {
                        $this->resources[] = $provider;
                    }
                }
            }
            
            // Sort by name
            usort($this->resources, function ($a, $b) {
                return ($a->getResourceName() < $b->getResourceName() ? -1 : 1);
            });
        }
    }
    
    
    /**
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }
    
    
    /**
     * @return array
     */
    public function getResourcesAsArray()
    {
        $resources = [];
        
        foreach ($this->getResources() as $provider) {
            $resources = ArrayUtils::merge($resources, $provider->getResourcesAsArray(), true);
        }
        asort($resources);
        
        return $resources;
    }
    
    
    /**
     * @return void
     */
    public function getResourcesAsValueOptions()
    {
        return $this->parseNestedArrayToValueOptions($this->getResourcesAsArray());
    }
    
    
    /**
     * @param array $nestedArray
     * @return array
     */
    public function parseNestedArrayToValueOptions($nestedArray)
    {
        $valueOptions = [];
        foreach ($nestedArray as $resource => $privileges) {
            $valueOptions[$resource] = $resource;
            
            foreach ($privileges as $privilege) {
                $value = "$resource-$privilege";
                
                $valueOptions[$value] = $value;
            }
        }
        return $valueOptions;
    }
    
    
    /**
     * @param array $valueOptions
     * @return array
     */
    public function parseValueOptionsToNestedArray($valueOptions)
    {
        $list = [];
        
        // For the record, the standard assumes the Resource and Privilege
        // are underscore-separated names. If there's a dash, it's a
        // separator between Resource and Privilege. We're only expecting one.
        foreach ($valueOptions as $option) {
            $parts = explode('-', $option);
            
            if (count($parts) > 2) {
                throw new \RuntimeException("Malformed value option \"$option\". Expecting to find only two parts, but more found. Maybe the Resource or Privilege might contain a dash when it should\'t?");
            }
            
            $resource = $parts[0];
            
            if (!isset($list[$resource])) {
                $list[$resource] = [];
            }
            
            if (isset($parts[1])) {
                $list[$resource][] = $parts[1];
            }
        }
        
        return $list;
    }
}
