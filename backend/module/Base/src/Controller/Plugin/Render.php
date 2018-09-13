<?php
namespace Base\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

/**
 * Provides a short way to instance and setup a ViewModel.
 *
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Render extends AbstractPlugin
{
    /**
     * @param string $template Template name
     * @param array|Traversable|null $vars
     * @return ViewModel
     */
    public function __invoke($template, $vars = null)
    {
        $viewModel = new ViewModel($vars);
        $viewModel->setTemplate($template);
        return $viewModel;
    }
}
