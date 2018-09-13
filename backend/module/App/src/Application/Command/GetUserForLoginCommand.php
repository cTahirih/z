<?php
namespace App\Application\Command;

use DDD\Command\Command;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetUserForLoginCommand implements Command
{
    /**
     * @var string
     */
    public $username;
    
    /**
     * @var string
     */
    public $password;
    
    
    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function __construct(
        string $username,
        string $password
    ) {
        $this->username = $username;
        $this->password = $password;
    }
}
