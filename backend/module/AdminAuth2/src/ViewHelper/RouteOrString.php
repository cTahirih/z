<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\ViewHelper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper that returns a URL string from either a route or a literal URL.
 * If the parameter passed is an array, it is used to build a route. If the
 * parameter is an string, it's considered a plain URL and returned as is.
 *
 * This View Helper is used by the AdminAuth2 Menus.
 *
 * @see AbstractHelper
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
class RouteOrString extends AbstractHelper
{
    public function __invoke($routeOrString)
    {
        if (is_array($routeOrString)) {
            // Build a route and return it as string.
            // First item of the array should be an string with the route.
            // Second item of the array is optional. If present, it should be
            // an array with the parameters to pass to build the route.
            if (empty($routeOrString)) {
                throw new \RuntimeException("RouteOrString array route can't be empty!");
            }
            
            $route      = $routeOrString[0];
            $parameters = (isset($routeOrString[1]) ? $routeOrString[1] : []);
            
            if (!is_string($route)) {
                throw new \RuntimeException(sprintf("RouteOrString route part must be of type string, got %s instead.", gettype($route)));
            }
            
            return $this->getView()->url($route, $parameters);
            
        } elseif (is_string($routeOrString)) {
            return $routeOrString;
        }
        
        throw new \RuntimeException(sprintf("RouteOrString parameter should be an array or a string, got %s instead.", gettype($routeOrString)));
    }
}
