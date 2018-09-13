<?php
namespace App\Controller;

use Base\Env;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @see AbstractActionController
 * @package App
 */
class IndexController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function homeAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('app/home');
        return $viewModel;
    }
}
