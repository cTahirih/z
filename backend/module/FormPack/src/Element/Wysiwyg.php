<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;

/**
 * Textarea WYSIWYG (CKeditor) Element
 *
 * On your view, remember to add the required CKEditor javascript code.
 * Also, an 'id' attribute is required by CKEditor.
 * 
 * @see Textarea
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Wysiwyg extends Textarea implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'class' => 'wysiwyg',
        ]);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        $spec = parent::getInputSpecification();
        $spec['filters'] = [
            ['name' => 'StringTrim'],
        ];
        
        return $spec;
    }
}
