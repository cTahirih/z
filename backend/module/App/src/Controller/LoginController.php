<?php
namespace App\Controller;

use App\Application\Command\GetUserForLoginCommand;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * @see AbstractActionController
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginController extends AbstractActionController
{
    /**
     * @var Container
     */
    protected $session;
    
    /**
     * @var Form
     */
    protected $loginForm;
    
    
    /**
     * @param Form $loginForm
     * @return void
     */
    public function __construct(
        Container $session,
        Form $loginForm
    ) {
        $this->session   = $session;
        $this->loginForm = $loginForm;
    }
    
    
    /**
     * @return ViewModel|\Zend\Http\Response
     */
    public function loginAction()
    {
        $form         = $this->loginForm;
        $request      = $this->getRequest();
        $session      = $this->session;
        $invalidLogin = false;
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data    = $form->getData();
                $command = new GetUserForLoginCommand($data['username'], $data['password']);
                $user    = $this->commandBus()->handle($command);
                
                if (is_null($user) == false) {
                    $session['user'] = $user;
                    return $this->redirect()->toRoute('dashboard');
                }
                
                $invalidLogin = true;
            }
        }
        
        $viewModel = new ViewModel([
            'form'         => $form,
            'invalidLogin' => $invalidLogin,
        ]);
        $viewModel->setTemplate('app/login');
        return $viewModel;
    }
    
    
    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->session->offsetUnset('user');
        return $this->redirect()->toRoute('login');
    }
}
