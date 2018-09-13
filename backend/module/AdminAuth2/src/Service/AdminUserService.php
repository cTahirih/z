<?php
namespace AdminAuth2\Service;

use AdminAuth2\Entity\AdminUser;
use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Service\AdminRoleService;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUserService {
    /**
     * @var EntityManager Doctrine Entity Manager
     */
    protected $entityManager;
    
    /**
     * @var DoctrineHydrator Doctrine Object Hydrator
     */
     protected $doctrineHydrator;
     
    
    /**
     * Constructor
     * 
     * @param EntityManager $entityManager
     * @param DoctrineHydrator $doctrineHydrator
     * @return void
     */
    public function __construct(
        EntityManager $entityManager,
        DoctrineHydrator $doctrineHydrator,
        AdminRoleService $adminRoleService
    ) {
        $this->entityManager    = $entityManager;
        $this->doctrineHydrator = $doctrineHydrator;
        $this->adminRoleService = $adminRoleService;
    }
    
    
    /**
     * @param strig $password
     * @throws RuntimeException
     * @return AdminUser
     */
    public function createSuperuser($password)
    {
        // Fetch "admin" role, it should already exist.
        try {
            $adminRole = $this->adminRoleService->findRoleByName('Admin');
        }
        catch (\Exception $e) {
            throw new \RuntimeException('Error fetching "Admin" role.');
        }
        
        if ($this->existsSuperuser()) {
            throw new RuntimeException('Can\'t create Superuser, it already exists.');
        }
        
        $data = [
            'name'         => 'Admin',
            'username'     => 'admin',
            'email'        => 'desarrollo@nodosdigital.pe',
            'password'     => $password,
            'role'         => $adminRole,
            'active'       => true,
            'is_superuser' => true,
        ];
        
        return $this->createUser($data);
    }
    
    
    /**
     * @param array $data
     * @return AdminUser
     */
    public function createUser($data)
    {
        $adminUser = new AdminUser();
        $this->doctrineHydrator->hydrate($data, $adminUser);
        
        $this->entityManager->persist($adminUser);
        $this->entityManager->flush();
        
        return $adminUser;
    }
    
    
    /**
     * @return bool
     */
    public function existsSuperuser()
    {
        try {
            $adminRole = $this->entityManager->createQuery("
                SELECT u
                  FROM AdminAuth2\Entity\AdminUser u
                 WHERE u.username=:username
            ")
                ->setParameter('username', 'admin')
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
     * @param string $username
     * @param string $password
     * @return AdminUser
     * @throws RuntimeException, NoResultException
     */
    public function getUserWithLogin($username, $password)
    {
        $adminUser = $this->entityManager->createQuery("
            SELECT u
              FROM AdminAuth2\Entity\AdminUser u
             WHERE u.username=:username
               AND u.active=:active
        ")
            ->setParameters([
                'username' => $username,
                'active'   => true,
            ])
            ->getOneOrNullResult();
        
        if (is_null($adminUser)) {
            throw new RuntimeException('AdminUser does not exist');
        }
        
        if ($adminUser->passwordMatches($password)) {
            return $adminUser;
        }
        
        throw new RuntimeException('AdminUser passwords don\'t match.');
    }
    
    
    /**
     * @param string $username
     * @param string $password
     * @return AdminUser|null
     */
    public function getUserWithUsername($username)
    {
        return $this->entityManager->createQuery("
            SELECT u
              FROM AdminAuth2\Entity\AdminUser u
             WHERE u.username=:username
        ")
            ->setParameters([
                'username' => $username,
            ])
            ->getOneOrNullResult();
    }
    
    
    /**
     * @param AdminUser $adminUser
     * @return AdminUserService
     */
    public function save(AdminUser $adminUser)
    {
        $this->entityManager->persist($adminUser);
        $this->entityManager->flush();
        return $this;
    }
}
