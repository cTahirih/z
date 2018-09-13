<?php
namespace BackendTemplate\View\Helper;

use BackendTemplate\BackendTemplate;
use Zend\View\Helper\Partial as ZendViewPartial;
use Zend\View\Resolver\ResolverInterface;

class Partial extends ZendViewPartial
{
    /**
     * @var ResolverInterface
     */
    protected $resolver;
    
    
    /**
     * @param ResolverInterface $resolver
     * @return void
     */
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }
    
    
    public function __invoke($name = null, $values = null)
    {
        $prefixedName = BackendTemplate::addPrefix($name);
        
        // Replace only if the template exists
        if ($this->resolver->resolve($prefixedName)) {
            $name = $prefixedName;
        }
        
        return parent::__invoke($name, $values);
    }
}
