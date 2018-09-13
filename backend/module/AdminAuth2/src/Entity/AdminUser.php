<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Entity;

use AdminAuth2\Entity\AdminRole;
use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;

/**
 * AdminUser entity
 * 
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 * @ORM\Entity
 * @ORM\Table(name="admin_users")
 * @ORM\HasLifecycleCallbacks
 */
class AdminUser
{
    /**
     * @var integer ID
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;
    
    /**
     * @var string
     * @ORM\Column
     */
    protected $name;
    
    /**
     * @var string
     * @ORM\Column
     */
    protected $email;
    
    /**
     * @var string
     * @ORM\Column
     */
    protected $username;
    
    /**
     * @var string
     * @ORM\Column
     */
    protected $password;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $active = 1;
    
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $is_superuser = false;
    
    /**
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $admin_roles_id;
    
    /**
     * @var AdminRole
     * @ORM\ManyToOne(targetEntity="AdminRole", inversedBy="users")
     * @ORM\JoinColumn(name="admin_roles_id", referencedColumnName="id")
     */
    protected $role;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;
    
    /**
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $created_by;
    
    /**
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $updated_by;
    
    
    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return AdminUser
     * @since v1.0.0
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    
    /**
     * Get Email
     * 
     * @return string
     * @since v1.0.0
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    
    /**
     * Set Email
     * 
     * @param string $email
     * @return AdminUser
     * @since v1.0.0
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    
    /**
     * Get Username
     * 
     * @return string
     * @since v1.0.0
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    
    /**
     * Set Username
     * 
     * @param string $username
     * @return AdminUser
     * @since v1.0.0
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    
    
    /**
     * Get Password
     * 
     * @return string
     * @since v1.0.0
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    
    /**
     * Set Password
     * 
     * @param string $password
     * @param boolean $encrypt True if should encrypt password
     * @return AdminUser
     * @since v1.0.0
     */
    public function setPassword($password, $encrypt = true)
    {
        if ($encrypt) {
            $password = $this->encryptPassword($password);
        }
        
        $this->password = $password;
        return $this;
    }
    
    
    /**
     * Encrypts a user's password
     *
     * @param string $password
     * @return string
     * @since v1.0.0
     */
    static public function encryptPassword($password)
    {
        return (new Bcrypt())->create($password);
    }
    
    
    /**
     * Returns true if password matches.
     *
     * @param string $password
     * @return boolean
     * @since v1.0.0
     */
    public function passwordMatches($password)
    {
        return (new Bcrypt())->verify($password, $this->getPassword());
    }
    
    
    /**
     * Get Active
     * 
     * @return boolean
     * @since v1.0.0
     */
    public function getActive()
    {
        return $this->active;
    }
    
    
    /**
     * Set Active
     * 
     * @param boolean $active
     * @return AdminUser
     * @since v1.0.0
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
        return $this;
    }
    
    
    /**
     * Get IsSuperuser
     * 
     * @return boolean
     * @since v1.0.0
     */
    public function getIsSuperuser()
    {
        return $this->is_superuser;
    }
    
    
    /**
     * Set IsSuperuser
     * 
     * @param boolean $is_superuser
     * @return AdminUser
     * @since v1.0.0
     */
    public function setIsSuperuser($is_superuser)
    {
        $this->is_superuser = (bool) $is_superuser;
        return $this;
    }
    
    
    /**
     * Returns true if user is superuser.
     *
     * @return boolean
     * @since v1.0.0
     */
    public function isSuperuser()
    {
        return $this->getIsSuperuser();
    }
    
    
    /**
     * Get admin_roles_id
     * 
     * @return int
     * @since v1.0.0
     */
    public function getAdminRolesId()
    {
        return $this->admin_roles_id;
    }
    
    
    /**
     * Set admin_roles_id
     * 
     * @param int $admin_roles_id
     * @return AdminUser
     * @since v1.0.0
     */
    public function setAdminRolesId($admin_roles_id)
    {
        $this->admin_roles_id = $admin_roles_id;
        return $this;
    }
    
    
    /**
     * Alias for `getAdminRolesId()`.
     * 
     * @since v1.0.0
     */
    public function getRoleId()
    {
        return $this->getAdminRolesId();
    }
    
    
    /**
     * Get Role
     * 
     * @return AdminRole
     * @since v1.0.0
     */
    public function getRole()
    {
        return $this->role;
    }
    
    
    /**
     * Set Role
     * 
     * @param AdminRole $role
     * @return AdminUser
     * @since v1.0.0
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    
    
    /**
     * Get Role's name
     *
     * @return string
     * @since v1.0.0
     */
    public function getRoleName()
    {
        if (is_null($this->role)) {
            return '';
        }
        
        return $this->role->getName();
    }
    
    
    /**
     * Get CreatedAt
     * 
     * @return \DateTime
     * @since v1.0.0
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    
    /**
     * Set CreatedAt
     * 
     * @param \DateTime $created_at
     * @return Register
     * @since v1.0.0
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    
    
    /**
     * Get UpdatedAt
     * 
     * @return \DateTime
     * @since v1.0.0
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    
    /**
     * Set UpdatedAt
     * 
     * @param \DateTime $updated_at
     * @return ThisClassName
     * @since v1.0.0
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
    
    
    /**
     * Get CreatedBy
     * 
     * @return int
     * @since v1.0.0
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    
    
    /**
     * Set CreatedBy
     * 
     * @param int $created_by
     * @return AdminRole
     * @since v1.0.0
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }
    
    
    /**
     * Get UpdatedBy
     * 
     * @return int
     * @since v1.0.0
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }
    
    
    /**
     * Set UpdatedBy
     * 
     * @param int $updated_by
     * @return AdminRole
     * @since v1.0.0
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
        return $this;
    }
    
    
    /**
     * Callback on Insert
     * 
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime('now'));
    }
    
    
    /**
     * Callback on Update
     * 
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }
}
