<?php
namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @see AbstractActionController
 * @package Base
 * @author Jaime G. Wong <@jgwong.org>
 */
class ViewRouteController extends AbstractActionController
{
    /**
     * Shorcut action for rendering a view template.
     *
     * The view template name should be defined in the route.
     * See `Base\Route::render()`.
     *
     * @see \Base\Route
     * @return ViewModel
     */
    public function viewAction()
    {
        return $this->render($this->params()->fromRoute('view'));
        $viewModel = new ViewModel();
        $viewModel->setTemplate($this->params()->fromRoute('view'));
        return $viewModel;
    }
}
