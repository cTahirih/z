<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

/**
 * A collection of methods for "flattening" Tabs.
 *
 * getData() by default will return a multidimensional array, one entry
 * for every Tab, containing every Element's values. flattenData() will
 * return a single array with every Element's values, as if Tabs doesn't
 * exist.
 *
 * setData() by default needs a multidimensional array to populate values
 * appropiately. This new setData() will receive a single array and, using
 * the Form's Tabs structure, populate the Elements inside every Tab.
 *
 * **Important Note:** For this flattening to work, every Element must have
 * a unique name.
 * 
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
namespace AdminAuth2\Form;

use AdminAuth2\Form\TabFieldsetInterface;
use Zend\Form\FormInterface;

trait TabbedFlatFormTrait
{
    /**
     * @return array
     * @since v1.0.0
     */
    public function getTabNames()
    {
        $return = [];
        foreach ($this->getTabList() as $tab) {
            $return[] = $tab->getName();
        }
        return $return;
    }
    
    
    /**
     * Flattens (merges) Tab Fieldsets into a single array.
     *
     * @param array $data
     * @return array
     * @since v1.0.0
     */
    public function flattenData($data)
    {
        $dataKeys = array_keys($data);
        $tabKeys  = $this->getTabNames();
        $return   = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $tabKeys, true)) {
                $return = array_merge($return, $data[$key]);
            } else {
                $return[$key] = $value;
            }
        }
        return $return;
    }
    
    
    /**
     * Explodes a single array data into a multidimensional mimicking the
     * Form's Tabs structure.
     *
     * @param array $data
     * @return array
     * @since v1.0.0
     */
    public function explodeData($data)
    {
        $return = [];
        foreach ($this as $tab) {
            $name = $tab->getName();
            $return[$name] = $this->getArrayForFieldset($tab, $data);
        }
        
        return $return;
    }
    
    
    /**
     * Iterates a Fieldset and returns an array with matching keys on $data.
     *
     * @param Fieldset $fieldset
     * @param array $data
     * @return array
     * @since v1.0.0
     */
    public function getArrayForFieldset($fieldset, $data)
    {
        $return = [];
        foreach ($fieldset as $element) {
            $name = $element->getName();
            
            if (array_key_exists($name, $data)) {
                $return[$name] = $data[$name];
            }
        }
        
        return $return;
    }
}
