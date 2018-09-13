<?php
namespace App\Application\Command;

use AdminAuth2\Exception\RuntimeException;
use AdminAuth2\Service\AdminUserService;
use App\Application\Dto\User;
use DDD\Command\Command;
use DDD\Command\CommandHandlerInterface;

/**
 * Returns a User DTO of an AdminUser that matches the login credentials.
 *
 * @see CommandHandler
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetUserForLoginCommandHandler implements CommandHandlerInterface
{
    /**
     * @var AdminUserService
     */
    protected $adminUserService;
    
    
    /**
     * @param AdminUserService $adminUserService
     * @return void
     */
    public function __construct(
        AdminUserService $adminUserService
    ) {
        $this->adminUserService = $adminUserService;
    }
    
    
    /**
     * @return User
     */
    public function handle(Command $command)
    {
        try {
            $user = $this->adminUserService->getUserWithLogin($command->username, $command->password);
        } catch (RuntimeException $e) {
            return null;
        }
        
        return new User($user->getId(), $user->getUsername());
    }
}
