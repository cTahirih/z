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
trait ListWithFormProviderTrait
{
    public function getListFormPartial()
    {
        return 'adminauth2/list_form';
    }
}
