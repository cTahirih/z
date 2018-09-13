<?php
namespace AdminAuth2\Controller;

use AdminAuth2\Service\AdminCoreService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Base\BaseController;

/**
 * @see AbstractActionController
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminAuth2BaseController extends AbstractActionController {
    /**
     * @var AdminCoreService
     */
    protected $adminCoreService;
    
    
    /**
     * @param AdminCoreService $adminCoreService
     * @return void
     */
    public function __construct(AdminCoreService $adminCoreService)
    {
        $this->adminCoreService = $adminCoreService;
    }
    
    
    /**
     * Returns true if there's NO user currently logged in.
     *
     * @return boolean
     */
    public function noUserLoggedIn()
    {
        return $this->adminCoreService->isUserLoggedIn() == false;
    }
    
    
    /**
     * Returns true if current User is allowed for specified privilege on
     * the current Provider's resource.
     *
     * @param string $privilege
     * @return bool
     */
    public function notAllowedForPrivilege($privilege)
    {
        return $this->adminCoreService->isAllowed($this->provider->getResourceName(), $privilege) == false;
    }
    
    
    /**
     * @return ViewModel
     */
    public function redirectToLogin()
    {
        return $this->redirect()->toRoute('admin');
    }
    
    
    /**
     * Returns a ViewModel with all the variables needed by the Layout.
     *
     * @param string $view
     * @param array $variables
     * @param array $options
     * @return ViewModel
     */
    public function renderView($view = '', $variables = [], $options = []) {
        $this->layout()->setTemplate('layout/adminauth2');
        $this->layout()->setVariables([
            'adminCoreService' => $this->adminCoreService,
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate($view);
        $viewModel->setVariables($variables);
        $viewModel->setOptions($options);
        
        return $viewModel;
    }
}
