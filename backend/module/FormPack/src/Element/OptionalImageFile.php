<?php
namespace FormPack\Element;

use Zend\Stdlib\ArrayUtils;

/**
 * Extends OptionalFile adding common validators for an Image file upload.
 *
 * @see OptionalFile
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class OptionalImageFile extends OptionalFile
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'view_link' => [
                'class' => 'fancybox',
            ],
        ]);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function setOptions($options)
    {
        $defaultOptions = [
            'show_view_link' => true,
        ];
        $options = ArrayUtils::merge($defaultOptions, $options);
        
        return parent::setOptions($options);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        $spec = [
            'validators' => [
                [
                    'name' => 'FileExtension',
                    'options' => [
                        'extension' => [
                            'jpg',
                            'jpeg',
                            'png',
                            'gif',
                        ],
                    ],
                ],
                
                [
                    'name' => 'FileMimeType',
                    'options' => [
                        'mimeType' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                    ],
                ],
            ],
        ];
        
        return ArrayUtils::merge($spec, parent::getInputSpecification());
    }
}
