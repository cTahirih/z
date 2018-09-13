<?php
namespace App\Infrastructure;

use Zend\Session\Container;

/**
 * @see Container;
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Session extends Container
{
    /**
     * @return Container
     */
    public function __construct()
    {
        return parent::__construct('application');
    }
    
    
    /**
     * @return bool
     */
    public function isUserLoggedIn()
    {
        return $this->offsetExists('user');
    }
}
