<?php
namespace FormPack\Element;

use Zend\Form\Element\Text as ZendText;
use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see ZendText
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Text extends ZendText implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttribute('autocomplete', 'off');
        $this->setAttribute('required', true);
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
