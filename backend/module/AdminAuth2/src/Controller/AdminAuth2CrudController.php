<?php
namespace AdminAuth2\Controller;

use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Provider\CrudProviderInterface;
use AdminAuth2\Provider\ListProviderInterface;
use AdminAuth2\Provider\ListWithSortProviderInterface;
use AdminAuth2\Provider\ListWithFormProviderInterface;
use AdminAuth2\Provider\MenuIdInterface;
use AdminAuth2\Service\AdminCoreService;
use Zend\Session\Container;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ViewModel;
use Base\BaseController;

/**
 * @see AdminAuth2BaseController
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminAuth2CrudController extends AdminAuth2BaseController {
    /**
     * @var mixed
     */
    protected $provider;
    
    /**
     * @var int Current page number
     */
    protected $page = 1;
    
    /**
     * @var bool Flag to merge FILES when doing file uploads
     */
    protected $mergeFiles = false;
    
    
    /**
     * @param AdminCoreService $adminCoreService
     * @param CrudProviderInterface $provider
     * @throws RuntimeException
     * @return void
     */
    public function __construct(AdminCoreService $adminCoreService, CrudProviderInterface $provider)
    {
        parent::__construct($adminCoreService);
        $this->provider = $provider;
        
        if ($provider instanceof MenuIdInterface) {
            $adminCoreService::setCurrentMenu($this->provider->getMenuId());
        }
    }
    
    
    /**
     * Overloads AdminAuth2BaseController::renderView() to add everything
     * needed by the CRUDs.
     *
     * @param string $view
     * @param mixed $variables
     * @param mixed $options
     * @throws RuntimeException
     * @return void
     */
    public function renderView($view = '', $variables = [], $options = []) {
        $viewModel = parent::renderView($view, $variables, $options);
        
        $variables['adminCoreService'] = $this->adminCoreService;
        $variables['page'] = $this->page;
        
        if (is_null($this->provider)) {
            throw new RuntimeException('Undefined Provider!');
        }
        $variables['provider'] = $this->provider;
        
        $viewModel->setVariables($variables);
        $viewModel->setOptions($options);
        
        $this->layout()->setVariables([
            'title'    => $this->provider->getName(),
            'provider' => $this->provider,
        ]);
        
        return $viewModel;
    }
    
    
    /**
     * Calls the provider to find a Record.
     *
     * @see AbstractActionController::notFoundAction()
     * @return void
     */
    public function findRecord()
    {
        $id = $this->params()->fromRoute('id');
        $provider = $this->provider;
        
        try {
            $provider->find($id);
        }
        catch (NotFoundException $e) {
            return $this->notFoundAction();
        }
    }
    
    
    /**
     * List action
     *
     * @throws RuntimeException
     * @return ViewModel
     */
    public function listAction()
    {
        if ($this->noUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        if ($this->notAllowedForPrivilege('list')) {
            return $this->redirectToLogin();
        }
        
        $provider = $this->provider;
        
        if (!$provider instanceOf ListProviderInterface) {
            throw new RuntimeException('Provider must implement ListProviderInterface.');
        }
        
        if ($provider instanceOf ListWithFormProviderInterface) {
            $this->processListWithForm();
        }
        
        // Handle Page query parameter
        $page = (integer) $this->params()->fromQuery('page', '1');
        $provider->setCurrentPage($page);
        
        // Handle sorting query parameters
        if ($provider instanceOf ListWithSortProviderInterface) {
            $sort = $this->params()->fromQuery('sort', null);
            $provider->setListSortField($sort);
            $sortDirection = $this->params()->fromQuery('sort-direction', null);
            $provider->setListSortDirection($sortDirection);
        }
        
        $provider->prepareList();
        
        $queryParameters = $this->params()->fromQuery();
        $queryParameters['page'] = $page;
        $routeOptions = [
            'query' => $queryParameters,
        ];
        
        return $this->renderView('adminauth2/list', [
            'routeOptions' => $routeOptions,
        ]);
    }
    
    
    /**
     * In the case of a Provider that implements ListWithFormProviderInterface
     * (i.e. a List with a Form), process the request. By default, it passes
     * the GET variables to the Provider.  
     * It's worth to mention it assumes the Form has a Submit-type button
     * named `submit`.
     *
     * @return void
     */
    public function processListWithForm()
    {
        $form   = $this->provider->getListForm();
        $submit = $this->params()->fromQuery('submit', false);
        
        if ($submit !== false) {
            $vars = $this->params()->fromQuery();
            // Ignore the GET value of the Submit button, otherwise, it can
            // be overwritten.
            unset($vars['submit']);
            $form->setData($vars);
            
            if ($form->isValid()) {
                $this->provider->processListFormRequest($form->getData());
            }
        }
    }
    
    
    /**
     * View action
     *
     * @return ViewModel
     */
    public function viewAction()
    {
        if ($this->noUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        if ($this->notAllowedForPrivilege('view')) {
            return $this->redirectToLogin();
        }
        
        $id = $this->params()->fromRoute('id');
        $this->findRecord();
        
        return $this->renderView('adminauth2/view', compact('id'));
    }
    
    
    /**
     * Add action
     *
     * @return ViewModel
     */
    public function addAction()
    {
        if ($this->noUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        if ($this->notAllowedForPrivilege('add')) {
            return $this->redirectToLogin();
        }
        
        $provider = $this->provider;
        $form     = $provider->getForm('add');
        $id       = '0';
        
        $queryParameters = $this->params()->fromQuery();
        $queryParameters['page'] = $this->params()->fromQuery('page', '1');
        $routeOptions = [
            'query' => $queryParameters,
        ];
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->mergeFiles) {
                $data = ArrayUtils::merge($request->getPost()->toArray(), $request->getFiles()->toArray(), true);
            } else {
                $data = $request->getPost()->toArray();
            }
            $form->setData($data);
            
            if ($form->isValid()) {
                $data               = $form->getData();
                $data['created_by'] = $this->adminCoreService->getUser()->getId();
                $provider->add($data);
                return $this->redirect()->toRoute($this->provider->getRoute(), [], $routeOptions);
            }
        }
        
        return $this->renderView('adminauth2/add', compact('id', 'form', 'routeOptions'));
    }
    
    
    /**
     * Edit action
     *
     * @return ViewModel
     */
    public function editAction()
    {
        if ($this->noUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        if ($this->notAllowedForPrivilege('edit')) {
            return $this->redirectToLogin();
        }
        
        $id       = $this->params()->fromRoute('id');
        $provider = $this->provider;
        
        $this->findRecord();
        $form = $provider->getForm('edit');
        
        $queryParameters = $this->params()->fromQuery();
        $queryParameters['page'] = $this->params()->fromQuery('page', '1');
        $routeOptions = [
            'query' => $queryParameters,
        ];
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->mergeFiles) {
                $data = ArrayUtils::merge($request->getPost()->toArray(), $request->getFiles()->toArray(), true);
            } else {
                $data = $request->getPost()->toArray();
            }
            $form->setData($data);
            
            if ($form->isValid()) {
                $data               = $form->getData();
                $data['updated_by'] = $this->adminCoreService->getUser()->getId();
                $provider->edit($data);
                return $this->redirect()->toRoute($this->provider->getRoute(), [], $routeOptions);
            }
        } else {
            $form->setData($provider->getData());
        }
        
        return $this->renderView('adminauth2/edit', compact('id', 'form', 'routeOptions'));
    }
    
    
    /**
     * Delete action
     *
     * @return ViewModel
     */
    public function deleteAction()
    {
        if ($this->noUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        if ($this->notAllowedForPrivilege('delete')) {
            return $this->redirectToLogin();
        }
        
        $this->findRecord();
        if (!is_null($this->provider->getRecord())) {
            $this->provider->delete();
        }
        
        $queryParameters = $this->params()->fromQuery();
        $queryParameters['page'] = $this->params()->fromQuery('page', '1');
        $routeOptions = [
            'query' => $queryParameters,
        ];
        
        return $this->redirect()->toRoute($this->provider->getRoute(), [], $routeOptions);
    }
}
