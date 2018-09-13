<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see Telephone
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Cellphone extends Telephone
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'minlength' => 9,
            'maxlength' => 9,
        ]);
    }
}
