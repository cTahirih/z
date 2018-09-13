<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Service;

use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Entity\AdminRole;
use AdminAuth2\Service\ResourceService;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Zend\Permissions\Acl\Acl;

/**
 * AdminRoleService
 * 
 * @package AdminAuth2
 * @version v1.0.1
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class AdminRoleService {
    /**
     * @var EntityManager Doctrine Entity Manager
     */
    protected $entityManager;
    
    /**
     * @var DoctrineHydrator Doctrine Object Hydrator
     */
     protected $doctrineHydrator;
     
     /**
      * @var ResourceService
      */
     protected $resouceService;
    
    /**
     * Constructor
     * 
     * @param EntityManager $entityManager
     * @param DoctrineHydrator $doctrineHydrator
     * @return void
     * @since v1.0.0
     */
    public function __construct(
        EntityManager $entityManager,
        DoctrineHydrator $doctrineHydrator,
        ResourceService $resourceService
    ) {
        $this->entityManager    = $entityManager;
        $this->doctrineHydrator = $doctrineHydrator;
        $this->resourceService  = $resourceService;
    }
    
    
    /**
     * Creates the default Admin role, which is a user with all the
     * current permissions declared in the system.
     *
     * @throws RuntimeException;
     * @return int Role ID
     * @since v1.0.0
     */
    public function createAdminRole()
    {
        if ($this->adminRoleExists()) {
            throw new RuntimeException('Can\'t create Admin role, it already exists');
        }
        
        // This user has all the permissions
        $resources = $this->resourceService->getResourcesAsArray();
        
        $data = [
            'name'        => 'Admin',
            'description' => 'Default Administration role',
            'resources' => json_encode($resources),
        ];
        
        return $this->createRole($data);
    }
    
    
    /**
     * Updates the "Admin" Role assigning it all the Resources available.
     *
     * @return void
     * @since v1.0.0
     */
    public function assignAllResourcesToAdminRole()
    {
        $adminRole = $this->findRoleByName('Admin');
        
        $resources = $this->resourceService->getResourcesAsArray();
        $adminRole->setResources(json_encode($resources));
        $this->save($adminRole);
    }
    
    
    /**
     * Create a Role
     *
     * @param array $data
     * @return int ID
     * @since v1.0.0
     */
    public function createRole($data)
    {
        $adminRole = new AdminRole();
        $this->doctrineHydrator->hydrate($data, $adminRole);
        
        $this->entityManager->persist($adminRole);
        $this->entityManager->flush();
        
        return $adminRole->getId();
    }
    
    
    /**
     * Admin Role exists?
     *
     * @return boolean
     * @since v1.0.0
     */
    public function adminRoleExists()
    {
        try {
            $adminRole = $this->entityManager->createQuery("
                SELECT r
                  FROM AdminAuth2\Entity\AdminRole r
                 WHERE r.name=:name
            ")
                ->setParameter('name', 'Admin')
                ->getSingleResult();
        }
        catch (NonUniqueResultException $e)
        {
            return true;
        }
        catch (NoResultException $e)
        {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Returns an active Role by name.
     *
     * @param $name
     * @return AdminRole
     * @since v1.0.0
     */
    public function findRoleByName($name)
    {
        return $this->entityManager->createQuery("
            SELECT r
              FROM AdminAuth2\Entity\AdminRole r
             WHERE r.name=:name
               AND r.active=:active
        ")
            ->setParameters([
                'name'   => $name,
                'active' => true,
            ])
            ->getSingleResult();
    }
    
    
    /**
     * Returns a Value Options list of Roles.
     *
     * @return void
     * @since v1.0.0
     */
    public function getOptionsList()
    {
        $list = $this->entityManager->createQuery("
            SELECT r.id, r.name
              FROM AdminAuth2\Entity\AdminRole r
             WHERE r.active=:active
        ")
            ->setParameter('active', true)
            ->getResult();
        
        $result = [];
        foreach ($list as $item) {
            $result[$item['id']] = $item['name'];
        }
        
        return $result;
    }
    
    
    /**
     * Creates a Zend\Permissions\Acl\Acl object for a given Role ID.
     *
     * @param int $roleId
     * @return Acl
     * @since v1.0.0
     */
    public function getAclFor($roleId)
    {
        $role = $this->entityManager->find('AdminAuth2\Entity\AdminRole', $roleId);
        
        if (is_null($role)) {
            throw new \RuntimeException("Role with ID $roleId not found!");
        }
        
        $roleId    = (string) $roleId;
        $resources = $role->getResourcesAsArray();
        
        $acl = new Acl();
        $acl->addRole($roleId);
        
        foreach ($resources as $resource => $privilege) {
            $acl->addResource($resource);
            $acl->allow($roleId, $resource, $privilege);
        }
        
        return $acl;
    }
    
    
    /**
     * Saves an AdminRole.
     *
     * @param AdminRole $adminRole
     * @return AdminRoleService
     * @since v1.0.0
     */
    public function save(AdminRole $adminRole)
    {
        $this->entityManager->persist($adminRole);
        $this->entityManager->flush();
        return $this;
    }
}
