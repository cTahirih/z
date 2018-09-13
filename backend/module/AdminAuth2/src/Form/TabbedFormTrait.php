<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Form;

use AdminAuth2\Form\TabFieldsetInterface;
use Zend\Form\Fieldset;

/**
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
trait TabbedFormTrait
{
    /**
     * Returns a list of Elements that implement
     * AdminAuth2\Form\TabFieldsetInterface by iterating the Form's Elements.
     *
     * @return array
     * @since v1.0.0
     */
    public function getTabList()
    {
        return $this->findTabFieldsetsInFieldset($this);
    }
    
    
    /**
     * Finds TabFieldsetInterface Elements inside Fieldsets recursively.
     *
     * @param Fieldset $fieldset
     * @return array
     * @since v1.0.0
     */
    protected function findTabFieldsetsInFieldset($fieldset)
    {
        $list = [];
        foreach ($fieldset as $element) {
            if ($element instanceof Fieldset) {
                if ($element instanceof TabFieldsetInterface) {
                    $list[] = $element;
                } else {
                    $tabs = $this->findTabFieldsetsInFieldset($element);
                    $list = array_merge($list, $tabs);
                }
            }
        }
        
        return $list;
    }
}
