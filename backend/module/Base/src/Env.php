<?php
namespace Base;

use RuntimeException;

/**
 * Handle system-wide environment.
 *
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Env
{
    /**
     * @var string
     */
    static protected $environment = 'production';
    
    
    /**
     * @return string
     */
    static public function get()
    {
        return self::$environment;
    }
    
    
    /**
     * @param string $environment
     * @return void
     */
    static public function set($environment)
    {
        if (!is_string($environment)) {
            throw new RuntimeException(sprintf('Incorrect type, environment value should be a string. Received: ', gettype($environment)));
        }
        
        self::$environment = $environment;
    }
    
    
    /**
     * @param string $environment
     * @return bool
     */
    static public function is($environment)
    {
        return self::$environment == $environment;
    }
    
    
    /**
     * @return bool
     */
    static public function isProduction()
    {
        return self::is('production');
    }
    
    
    /**
     * @return bool
     */
    static public function isDevelopment()
    {
        return self::is('development');
    }
    
    
    /**
     * @return bool
     */
    static public function isTesting()
    {
        return self::is('testing');
    }
}
