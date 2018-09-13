<?php
namespace Base;

use Base\Controller\ViewRouteController;
use Zend\Router\Http\Literal;

/**
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Route
{
    /**
     * Returns a route config array for rendering a view file with
     * `Base\Controller\ViewRouteController`.
     *
     * @see ViewRouteController.
     * @param string $route
     * @param string $view
     * @return array
     */
    static public function render($route, $view)
    {
        return [
            'type' => Literal::class,
            'options' => [
                'route' => $route,
                'defaults' => [
                    'controller' => ViewRouteController::class,
                    'action' => 'view',
                    'view' => $view,
                ],
            ],
        ];
    }
}
