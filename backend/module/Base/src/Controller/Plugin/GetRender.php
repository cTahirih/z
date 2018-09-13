<?php
/**
 * This file is part of Base Zend Framework 2 module.
 */

namespace Base\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Renderer\RendererInterface;
use Zend\View\ViewModel;

/**
 * Returns the rendered version of a template.
 *
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetRender extends AbstractPlugin
{
    /**
     * @var RendererInterface
     */
    protected $viewRenderer;
    
    
    /**
     * @param RendererInterface $viewRenderer
     * @return void
     */
    public function __construct(RendererInterface $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }
    
    
    /**
     * @param string $template Template name
     * @param array|Traversable|null $values
     * @return string
     */
    public function __invoke($template, $values = null)
    {
        return $this->viewRenderer->render($template, $values);
    }
}
