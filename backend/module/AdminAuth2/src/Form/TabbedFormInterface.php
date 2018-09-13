<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Form;

/**
 * This interface declares that a given Form contains Fieldsets as Tabs.
 * See also TabFieldsetInterface.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
interface TabbedFormInterface
{
    /**
     * Returns an array of Fieldsets that are Tabs. In other words, Elements
     * that implement AdminAuth2\Form\TabFieldsetInterface.
     *
     * @return array
     * @since v1.0.0
     */
    public function getTabList();
}
