<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use Zend\Form\Form;

interface ListWithFormProviderInterface
{
    /**
     * @return Form
     * @since v1.0.0
     */
    public function getListForm();
    
    
    /**
     * Processes a request for a List Form.
     *
     * @param mixed $data
     * @return mixed
     * @since v1.0.0
     */
    public function processListFormRequest($data);
    
    
    /**
     * Returns the name of the partial which contains the List Form.
     *
     * @return string
     * @since v1.0.0
     */
    public function getListFormPartial();
}
