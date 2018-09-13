<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * Declares that a Provider can return Menu IDs for the Menu.
 *
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
interface MenuIdInterface
{
    /**
     * Returns a list of Menu IDs.
     *
     * @return array
     * @since v1.0.0
     */
    public function getMenuId();
}
