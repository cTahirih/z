<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
interface MenuProviderInterface
{
    /**
     * Returns an array with Menu definitions.
     *
     * The structure is as follows:
     *
     * [
     *     'partial' - Optional. If specified, use this Partial instead.
     *
     * @return array
     * @since v1.0.0
     */
    public function getMenus();
}
