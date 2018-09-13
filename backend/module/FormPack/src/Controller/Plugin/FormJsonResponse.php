<?php
namespace FormPack\Controller\Plugin;

use Zend\Form\Form;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\JsonModel;
 
/**
 * Returns a Form's validation status as a JSON View Model response.
 *
 * @see AbstractPlugin
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class FormJsonResponse extends AbstractPlugin
{
    /**
     * @param Form $form
     * @return JsonModel
     */
    public function __invoke(Form $form)
    {
        $response = [
            'is_valid' => $form->isValid(),
            'messages' => $this->getController()->formMessages($form),
        ];
        
        return new JsonModel($response);
    }
}
