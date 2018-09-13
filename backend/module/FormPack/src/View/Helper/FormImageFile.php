<?php
namespace FormPack\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormFile;

/**
 * View Helper for FormPack\Element\ImageFile
 *
 * @see FormFile
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class FormImageFile extends FormFile
{
    /**
     * @inheritDoc
     */
    public function render(ElementInterface $element)
    {
        $html  = parent::render($element);
        $html .= "<br />\n";
        
        if (!empty($element->getFilename())) {
            $html .= sprintf(
                '<a href="%s" target="_blank">View image</a>',
                $this->view->basePath($element->getWebFilename())
            );
            
            if ($element->getOption('allow_remove')) {
                $name    = $element->getName() . '-ImageFileRemove';
                $checked = (isset($_POST[$name]) ? ' checked' : '');
                
                $html .= sprintf(
                    ' or <label><input type="checkbox" name="%s" value="1"%s> remove</label>',
                    $name,
                    $checked
                );
            }
        }
        
        return $html;
    }
}
