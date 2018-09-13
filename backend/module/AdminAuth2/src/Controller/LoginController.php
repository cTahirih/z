<?php
namespace AdminAuth2\Controller;

use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Service\AdminCoreService;
use AdminAuth2\Service\AdminRoleService;
use AdminAuth2\Service\AdminUserService;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * @see AbstractActionController
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginController extends AbstractActionController
{
    /**
     * @var AdminCoreService
     */
    protected $adminCoreService;
    
    /**
     * @var AdminUserService
     */
    protected $adminUserService;
    
    /**
     * @var AdminRoleService
     */
    protected $adminRoleService;
    
    /**
     * @var Form
     */
    protected $form;
    
    
    /**
     * @param AdminCoreService $adminCoreService
     * @param AdminUserService $adminUserService
     * @param AdminRoleService $adminRoleService
     * @param Form $form
     * @return void
     */
    public function __construct(
        AdminCoreService $adminCoreService,
        AdminUserService $adminUserService,
        AdminRoleService $adminRoleService,
        Form $form
    ) {
        $this->adminCoreService = $adminCoreService;
        $this->adminUserService = $adminUserService;
        $this->adminRoleService = $adminRoleService;
        $this->form             = $form;
    }
    
    
    /**
     * @return ViewModel
     */
    public function loginAction()
    {
        if ($this->adminCoreService->isUserLoggedIn()) {
             return $this->redirect()->toRoute('admin/dashboard');
        }
        
        $form = $this->form;
        $message = '';
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                try {
                    $user = $this->adminUserService->getUserWithLogin($data['username'], $data['password']);
                    
                    $this->adminCoreService->setUser($user);
                    $this->adminCoreService->setAcl($this->adminRoleService->getAclFor($user->getRole()->getId()));
                    $this->adminCoreService->getEventManager()->trigger('loginValid', $this);
                    
                    return $this->redirect()->toRoute('admin/dashboard');
                }
                catch (RuntimeException $e) {
                    $message = 'Invalid user or password. Please try again.';
                }
                catch (\Exception $e) {
                    echo $e; exit;
                }
            } else {
                $this->adminCoreService->getEventManager()->trigger('loginInvalid', $this);
            }
        }
        
        $viewModel = new ViewModel(compact('form', 'message'));
        $viewModel->setTemplate('adminauth2/login');
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->adminCoreService->getEventManager()->trigger('logout', $this);
        $this->adminCoreService->logoutUser();
        return $this->redirect()->toRoute('admin');
    }
    
    
    /**
     * @return AdminCoreService
     */
    public function getAdminCoreService()
    {
        return $this->adminCoreService;
    }
    
    
    /**
     * @return AdminUserService
     */
    public function getAdminUserService()
    {
        return $this->adminUserService;
    }
    
    
    /**
     * @return AdminRoleService
     */
    public function getAdminRoleService()
    {
        return $this->adminRoleService;
    }
}
