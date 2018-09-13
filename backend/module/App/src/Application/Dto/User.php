<?php
namespace App\Application\Dto;

/**
 * Response for GetUserForLoginCommandHandler
 *
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class User
{
    /**
     * @var integer
     */
    public $userId;
    
    /**
     * @var string
     */
    public $username;
    
    
    /**
     * @param integer $userId
     * @param string $username
     * @return void
     */
    public function __construct($userId, $username)
    {
        $this->userId   = $userId;
        $this->username = $username;
    }
    
    
    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
