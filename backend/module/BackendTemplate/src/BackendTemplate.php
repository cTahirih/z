<?php
namespace BackendTemplate;

/**
 * An static methods collection.
 *
 * @package BackendTemplate
 * @author Jaime G. Wong <j@jgwong.org>
 */
class BackendTemplate
{
    /**
     * Given the global Config array, tell if the Backend Template prefixing
     * is active or not.
     *
     * @param array $config
     * @return bool
     */
    static public function isActive($config)
    {
        if (
            array_key_exists('show_backend_template', $config) == false
            || $config['show_backend_template'] == false
        ) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Add an underscore prefix to the template name.  
     * e.g. For `foo/bar/baz` will output: `foo/bar/_baz`
     *
     * @param string $template
     * @return string
     */
    static public function addPrefix($template)
    {
        $parts    = array_reverse(explode('/', $template));
        $parts[0] = '_' . $parts[0];
        return join(array_reverse($parts), '/');
    }
}
