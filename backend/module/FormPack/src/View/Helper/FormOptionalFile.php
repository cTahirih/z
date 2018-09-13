<?php
namespace FormPack\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Element\Element;
use Zend\Form\View\Helper\FormFile;

/**
 * View Helper for FormPack\Element\OptionalFile
 *
 * @see FormFile
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class FormOptionalFile extends FormFile
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        $this->validTagAttributes['target'] = true;
    }
    
    
    /**
     * @inheritDoc
     */
    public function render(ElementInterface $element)
    {
        $html = '';
        
        if (!empty($element->getCurrentFileName())) {
            if ($element->getOption('show_view_link')) {
                $html .= $this->getViewLinkHtml($element);
            }
            
            if ($element->getOption('allow_remove')) {
                $html .= (empty($html) ? '' : ' or ');
                $html .= $this->getRemoveCheckboxHtml($element);
            }
        }
        
        return parent::render($element) . $html;
    }
    
    
    /**
     * @param Element $element
     * @return string
     */
    public function getViewLinkHtml($element)
    {
        $attributes = $element->getAttributes();
        
        if (array_key_exists('view_link', $attributes)) {
            $attributes = $attributes['view_link'];
        } else {
            $attributes = [];
        }
        
        return sprintf(
            '<a href="%s" %s>View file</a>',
            $this->view->basePath($element->getViewFileName()),
            $this->createAttributesString($attributes)
        );
    }
    
    
    /**
     * @param Element $element
     * @return void
     */
    public function getRemoveCheckboxHtml($element)
    {
        $name = $element->getRemoveName();
        $attributes = [
            'type'  => 'checkbox',
            'id'    => $name,
            'name'  => $name,
        ];
        $checked = (isset($_POST[$name]) ? ' checked' : '');
        
        return sprintf(
            '<label><input %s%s%s Remove file</label>',
            $this->createAttributesString($attributes),
            $checked,
            $this->getInlineClosingBracket()
        );
    }
}
