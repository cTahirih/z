<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AdminRole entity
 * 
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 * @ORM\Entity
 * @ORM\Table(name="admin_roles")
 * @ORM\HasLifecycleCallbacks
 */
class AdminRole
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
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $resources;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $active = true;
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AdminUser", mappedBy="role")
     */
    protected $users;
    
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
     * @return AdminRole
     * @since v1.0.0
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    
    /**
     * Get Description
     * 
     * @return string
     * @since v1.0.0
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    /**
     * Set Description
     * 
     * @param string $description
     * @return AdminRole
     * @since v1.0.0
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    
    /**
     * Get Resources
     * 
     * @return string JSON-encoded array
     * @since v1.0.0
     */
    public function getResources()
    {
        return $this->resources;
    }
    
    
    /**
     * Set Resources
     * 
     * @param string $resources
     * @return AdminRole
     * @since v1.0.0
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }
    
    
    /**
     * Returns the Resources as an array.
     *
     * @return array
     * @since v1.0.0
     */
    public function getResourcesAsArray()
    {
        return json_decode($this->getResources(), true);
    }
    
    
    /**
     * Returns Resources for Admin.
     *
     * @return string
     * @since v1.0.0
     */
    public function getResourcesForAdmin()
    {
        $result = '';
        foreach ($this->getResourcesAsArray() as $resource => $privileges) {
            $result .= "<b>$resource</b>\n";
            $result .= "<ul>\n";
            foreach ($privileges as $privilege) {
                $result .= "<li> $privilege</li>\n";
            }
            $result .= "</ul>\n";
        }
        return $result;
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
     * @return AdminRole
     * @since v1.0.0
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
    
    
    /**
     * Get Users
     * 
     * @return ArrayCollection
     * @since v1.0.0
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    
    /**
     * Set Users
     * 
     * @param ArrayCollection $users
     * @return AdminRole
     * @since v1.0.0
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
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
