<?php
namespace FormPack\Element;

use Zend\Form\Element\Textarea as ZendTextarea;
use Zend\InputFilter\InputProviderInterface;

/**
 * @see ZendTextarea
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Textarea extends ZendTextarea implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'required'  => true,
            'minlength' => 1,
            'maxlength' => 65535, // Based on MySQL's max for TEXT data type
        ]);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        return [
            'required' => $this->getAttribute('required'),
            
            'filters'  => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => $this->getAttribute('minlength'),
                        'max' => $this->getAttribute('maxlength'),
                    ],
                ],
            ],
        ];
    }
}
