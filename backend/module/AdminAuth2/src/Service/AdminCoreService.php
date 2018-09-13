<?php
namespace AdminAuth2\Service;

use AdminAuth2\Entity\AdminUser;
use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Provider\MenuProviderInterface;
use Zend\EventManager\EventManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\PriorityList;
use Zend\View\Model\ViewModel;

/**
 * Provides core services for the AdminAuth2 interface itself, such as menus,
 * session, etc.
 *
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminCoreService
{
    /**
     * @var Container
     */
    protected $session;
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;
    
    /**
     * @var EventManager
     */
    protected $eventManager;
    
    /**
     * @var PriorityList
     */
    protected $menus;
    
    /**
     * @var string Route name for public-facing website (optional).
     */
    protected $websiteRoute;
    
    /**
     * @var array IDs of currently active items in Menu
     */
    static protected $currentMenu = [];
    
    
    /**
     * @param Container $session
     * @param array $config
     * @param ServiceLocatorInterface $serviceManager
     * @throws RuntimeException
     * @return void
     */
    public function __construct(
        Container $session,
        $config,
        ServiceLocatorInterface $serviceManager,
        EventManager $eventManager
    ) {
        $this->session        = $session;
        $this->serviceManager = $serviceManager;
        $this->eventManager   = $eventManager;
        $this->config         = $config;
        
        $this->eventManager->setIdentifiers(['adminauth2']);
        
        if (isset($config['adminauth2']['website_route'])) {
            $this->websiteRoute = $config['adminauth2']['website_route'];
        }
    }
    
    
    /**
     * Reads Menu entries from the config.
     *
     * @param array $config
     * @return void
     */
    public function buildMenuList($config)
    {
        $this->menus = new PriorityList();
        $menusConfig = [];
        
        if (isset($config['adminauth2']['menus'])) {
            $menusConfig = $config['adminauth2']['menus'];
        }
        
        if (isset($config['adminauth2']['providers'])) {
            foreach ($config['adminauth2']['providers'] as $providerName) {
                $provider = $this->serviceManager->get($providerName);
                if ($provider instanceof MenuProviderInterface) {
                    $menusConfig = ArrayUtils::merge($menusConfig, $provider->getMenus());
                }
            }
        }
        
        foreach ($menusConfig as $id => $menu) {
            if (!isset($menu['order'])) {
                $menu['order'] = 0;
            }
            
            // Invert sign, so instead of Priority, it behaves as Order
            $order = $menu['order'] * -1;
            
            // List of Resources/Privileges
            $resourcesAccess = [];
            
            // If it has children, convert them into a PriorityList too
            if (isset($menu['children']) && is_array($menu['children'])) {
                $children = new PriorityList();
                
                foreach ($menu['children'] as $childId => $child) {
                    if (!isset($child['order'])) {
                        $childOrder = 0;
                    } else {
                        // Invert sign, so instead of Priority, it behaves
                        // as Order
                        $childOrder = $child['order'] * -1;
                    }
                    
                    // Flag indicating if this item can be added after
                    // ACL verifications.
                    $addToList = true;
                    
                    // Check if there's a Resource requirement. If so, verify
                    // the current User has access to it.
                    if (array_key_exists('resources', $child)) {
                        $addToList = $this->isAllowedToAnyOf($child['resources']);
                    }
                    
                    if ($addToList) {
                        $children->insert($childId, $child, $childOrder);
                    }
                }
                
                $children->rewind();
                $menu['children'] = $children;
            }
            
            $addToList = true;
            
            // Check if there's a Resource requirement. If so, verify
            // the current User has access to it.
            if (array_key_exists('resources', $menu)) {
                $addToList = $this->isAllowedToAnyOf($menu['resources']);
                
            // Otherwise, if this menu entry has children and $children is
            // empty, it means no child got access. In that case, the parent
            // gets no access either.
            } elseif (isset($menu['children']) && count($menu['children']) == 0) {
                $addToList = false;
            }
            
            if ($addToList) {
                $this->menus->insert($id, $menu, $order);
            }
            
            $this->menus->rewind();
        }
    }
    
    
    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    
    /**
     * @return array
     */
    public function getMenus()
    {
        if (is_null($this->menus)) {
            $this->buildMenuList($this->config);
        }
        
        return $this->menus;
    }
    
    
    /**
     * @return string
     */
    public function getWebsiteRoute()
    {
        return $this->websiteRoute;
    }
    
    
    /**
     * @return Container
     */
    public function getSession()
    {
        return $this->session;
    }
    
    
    /**
     * @return AdminUser
     */
    public function getUser()
    {
        return $this->session['user'];
    }
    
    
    /**
     * @param AdminUser $user
     * @return AdminCoreService
     */
    public function setUser(AdminUser $user)
    {
        $this->session['user'] = $user;
        return $this;
    }
    
    
    /**
     * @return boolean
     */
    public function isUserLoggedIn()
    {
        return isset($this->session['user']);
    }
    
    
    /**
     * @return Acl
     */
    public function getAcl()
    {
        return $this->session['acl'];
    }
    
    
    /**
     * @param Acl $acl
     * @return AdminCoreService
     */
    public function setAcl($acl)
    {
        $this->session['acl'] = $acl;
        return $this;
    }
    
    
    /**
     * Consults the ACL and returns a boolean for the current logged in user.
     * It also overrides AdminRole permissions in the case of a superuser.
     *
     * @param \Zend\Permissions\Acl\Resource\ResourceInterface|string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($resource = null, $privilege = null)
    {
        $user = $this->getUser();
        
        // If it's a Superuser, then he/she always have access to
        // AdminUser and AdminRole.
        if ($user->isSuperUser() && in_array($resource, ['admin_users', 'admin_roles'])) {
            return true;
        }
        
        try {
            $roleId = $user->getRoleId();
            return $this->getAcl()->isAllowed($roleId, $resource, $privilege);
        }
        catch (InvalidArgumentException $e) {
            return false;
        }
    }
    
    
    /**
     * Returns true if the current user can access at least one of the given
     * set of Resources => Privileges. The array should have the following
     * format:
     *
     *     [
     *         'resourceName' => [
     *             'privilege_1',
     *             'privilege_2',
     *         ]
     *     ]
     *
     * @param string $resource
     * @param array $resources
     * @return bool
     */
    public function isAllowedToAnyOf($resources)
    {
        $allowed = false;
        
        foreach ($resources as $resource => $privileges) {
            foreach ($privileges as $privilege) {
                $allowed = $this->isAllowed($resource, $privilege);
                
                // Bail as soon as we get a `true`
                if ($allowed === true) {
                    break(2);
                }
            }
        }
        
        return $allowed;
    }
    
    
    /**
     * @return void
     */
    public function logoutUser()
    {
        $this->getSession()->getManager()->getStorage()->clear();
    }
    
    
    /**
     * Sets current selected item in the Menu sidebar
     *
     * @param string|array $entry One ID (string) or many IDs (array)
     * @return void
     */
    public static function setCurrentMenu($entry)
    {
        if (!is_array($entry)) {
            $entry = [$entry];
        }
        self::$currentMenu = $entry;
    }
    
    
    /**
     * Returns true if ID is a current selected Menu
     *
     * @param string $id
     * @return bool
     */
    public static function isCurrentMenu($id)
    {
       return in_array($id, self::$currentMenu);
    }
}
