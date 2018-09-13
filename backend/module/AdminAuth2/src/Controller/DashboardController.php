<?php
namespace AdminAuth2\Controller;

use AdminAuth2\Service\AdminCoreService;
use Zend\View\Model\ViewModel;

/**
 * @see AdminAuth2BaseController
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DashboardController extends AdminAuth2BaseController
{
    public function indexAction()
    {
        if ($this->NoUserLoggedIn()) {
            return $this->redirectToLogin();
        }
        
        // Variable assigned is needed in this case because of PHP 5.6 behavior
        $adminCoreService = $this->adminCoreService;
        $adminCoreService::setCurrentMenu('dashboard');
        return $this->renderView('adminauth2/dashboard');
    }
}
