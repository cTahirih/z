<?php
namespace FormPack\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Form\Form;
 
/**
 * When invalid, a Form's elements have each a list of error messages. Usually,
 * we need just the first one. This plugin returns an array of every element's
 * first message.
 *
 * @see AbstractPlugin
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class FormMessages extends AbstractPlugin
{
    /**
     * When invalid, a Form's elements have each a list of error messages.
     * Usually, we need just the first one. This plugin returns an array of
     * every element's first message.
     *
     * @param Form $form
     * @return array
     */
    public function __invoke(Form $form)
    {
        $list = [];
        foreach ($form->getMessages() as $element => $messages) {
            $list[$element] = current($messages);
        }
        
        return $list;
    }
}
