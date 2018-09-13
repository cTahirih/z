<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider\Doctrine;

use AdminAuth2\Exception\NotFoundException;
use AdminAuth2\Provider\ProviderField;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Orm\EntityManager;
use Zend\Filter\Word\CamelCaseToSeparator;
use Zend\Filter\Word\UnderscoreToCamelCase;
use Zend\Filter\Word\UnderscoreToSeparator;

/**
 * A Doctrine Implementation of the CrudProviderInterface.
 *
 * @package AdminAuth2
 * @version v1.0.1
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
trait DoctrineCrudProviderTrait
{
    /**
     * @var string
     */
    protected $route;
    
    /**
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * @var DoctrineHydrator
     */
    protected $hydrator;
    
    /**
     * @var string FQCN of Entity
     */
    protected $entityClass;
    
    /**
     * @var mixed
     */
    protected $entity;
    
    /**
     * @var string
     */
    protected $name;
    
    
    public function initializeDoctrineCrudProvider(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->hydrator      = new DoctrineHydrator($entityManager);
        
        if (is_null($this->entityClass)) {
            throw new \Exception('Undefined entity class name in Provider.');
        }
        
        if (is_null($this->name)) {
            throw new \RuntimeException('Undefined name in Provider.');
        }
    
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getName() {
        return $this->name;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        $this->entity = $this->entityManager->find($this->entityClass, $id);
        
        if (is_null($this->entity)) {
            throw new NotFoundException("An entity with ID $id was not found.");
        }
        
        return $this->entity;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getRecord()
    {
        if (is_null($this->entity)) {
            $className = $this->entityClass;
            $this->entity = new $className();
        }
        
        return $this->entity;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }
    
    
    /**
     * Return an array of ProviderField objects with the representation
     * of each field.
     *
     * In this implementation, it builds a default list by looking
     * after all the declared Doctrine fields. Then looks up for a getter
     * method with the name of `get{$fieldName}ForAdmin()`. If it doesn't
     * exist, it looks for the standard `get{$fieldName}()` getter method
     * instead. If even this one doesn't exist (???) the field is ignored.
     *
     * To ease posterior manipulation, the array's keys are the name of
     * the fields, camelCased, with the first letter in lowercase (e.g.:
     * `firstName`).
     *
     * @return array
     * @since v1.0.0
     */
    public function getFields()
    {
        if (is_null($this->fields)) {
            $entity       = $this->getRecord();
            $this->fields = [];
            
            $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();
            $camelCaseToSeparatorFilter  = new CamelCaseToSeparator();
            
            $metadata = $this->entityManager->getClassMetadata(get_class($entity));
            
            foreach ($metadata->getFieldNames() as $fieldName) {
                $labelName      = ucfirst(strtolower($camelCaseToSeparatorFilter->filter($fieldName)));
                
                if ($labelName == 'Id') {
                    $labelName = 'ID';
                }
                
                $camelCaseName  = $fieldName;
                $normalizedName = lcfirst($camelCaseName);
                
                $getterMethod      = 'get' . $camelCaseName;
                $adminGetterMethod = $getterMethod . 'ForAdmin';
                $methodName        = false;
                
                if (method_exists($entity, $adminGetterMethod)) {
                    $methodName = $adminGetterMethod;
                } elseif (method_exists($entity, $getterMethod)) {
                    $methodName = $getterMethod;
                }
                
                if ($methodName) {
                    $this->fields[$normalizedName] = new ProviderField($labelName, [$entity, $methodName]);
                }
            }
        }
        
        return $this->fields;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getField($field)
    {
        $fields = $this->getFields();
        
        if (!array_key_exists($fields, $field)) {
            throw new \RuntimeException("Field \"$field\" doesn't exist in Provider's Fields list.");
        }
        
        if (!$providerField instanceof ProviderField) {
            throw new \RuntimeException('Field must be an AdminAuth2\Provider\ProviderField instance.');
        }
        
        return $fields[$field];
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getViewFields()
    {
        return $this->getFields();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->hydrator->extract($this->entity);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function add($data)
    {
        $entity = $this->getRecord();
        $this->hydrator->hydrate($data, $entity);
        
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        
        return $entity->getId();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function edit($data)
    {
        return $this->add($data);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $this->entityManager->remove($this->entity);
        $this->entityManager->flush();
    }
    
    
    /**
     * {@inheritDoc}
     *
     * @throws \RuntimeException
     */
    public function getRoute()
    {
        if (is_null($this->route)) {
            throw new \RuntimeException('No route defined in Provider!');
        }
        
        return $this->route;
    }
}
