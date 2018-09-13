<?php
namespace App\Controller;

use App\Infrastructure\Session;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * @see AbstractActionController
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DashboardController extends AbstractActionController
{
    /**
     * @var Container
     */
    protected $session;
    
    
    /**
     * @param Container $session
     * @return void
     */
    public function __construct(
        Container $session
    ) {
        $this->session = $session;
    }
    
    
    /**
     * @return ViewModel
     */
    public function dashboardAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate('app/index');
        return $viewModel;
    }
}
