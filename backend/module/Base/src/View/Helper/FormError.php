<?php
namespace Base\View\Helper;

use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

/**
 * @see AbstractHelper
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class FormError extends AbstractHelper
{
    /**
     * Returns an HTML label with the error message for the given Element or
     * an empty string on no error.
     *
     * @param Element $element
     * @return string
     */
    public function __invoke(Element $element)
    {
        $messages = $element->getMessages();
        
        if (count($messages) == 0) {
            return '';
        }
        
        return sprintf('<label class="msg" for="%s">%s</label>',
            $element->getName(),
            current($messages)
        );
    }
}
