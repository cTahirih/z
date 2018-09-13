<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use AdminAuth2\Exception\NotFoundException;

/**
 * Interface: CrudProviderInterface
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
interface CrudProviderInterface
{
    /**
     * Returns the Name of this Section.
     *
     * @return string
     * @since v1.0.0
     */
    public function getName();
    
    
    /**
     * Find record. Should return the record or throw a NotFoundException
     * exception if it doesn't exist.
     *
     * @param int $id
     * @throws NotFoundException
     * @return mixed|false
     * @since v1.0.0
     */
    public function find($id);
    
    
    /**
     * Get current referenced record (usually, a Model or Entity).
     *
     * @return mixed
     * @since v1.0.0
     */
    public function getRecord();
    
    
    /**
     * Set Fields. Should be an array of ProviderField objects.
     *
     * @param array $fields
     * @return CrudProviderInterface
     * @since v1.0.0
     */
    public function setFields($fields);
    
    
    /**
     * Return an array of ProviderField objects with the representation
     * of each field.
     *
     * @return array
     * @since v1.0.0
     */
    public function getFields();
    
    
    /**
     * Returns a field from the internal list of Fields.
     *
     * @return ProviderField
     * @since v1.0.0
     */
    public function getField($field);
    
    
    /**
     * Get fields for View (Read) action.
     *
     * @return array|Iterable
     * @since v1.0.0
     */
    public function getViewFields();
    
    
    /**
     * Get Form for Add or Edit action.
     *
     * @param string $action Either `add` or `edit`. This makes possible
     * returning (or modifying) a Form object for either case.
     * @return \Zend\Form\Form
     * @since v1.0.0
     */
    public function getForm($action);
    
    
    /**
     * Extract data from record.
     *
     * @return mixed
     * @since v1.0.0
     */
    public function getData();
    
    
    /**
     * Add (insert) record.
     *
     * @param mixed $data
     * @return int ID of created model/entity.
     * @since v1.0.0
     */
    public function add($data);
    
    
    /**
     * Edit (update) record.
     *
     * @return void
     * @since v1.0.0
     */
    public function edit($data);
    
    
    /**
     * Delete record.
     *
     * @return void
     * @since v1.0.0
     */
    public function delete();
    
    
    /**
     * Get the base name to build CRUD routes from.
     *
     * @return string
     * @since v1.0.0
     */
    public function getRoute();
}
