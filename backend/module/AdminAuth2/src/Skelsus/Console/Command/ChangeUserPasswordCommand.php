<?php
namespace AdminAuth2\Skelsus\Console\Command;

use AdminAuth2\Service\AdminUserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ChangeUserPasswordCommand extends Command
{
    /**
     * @var AdminUserService
     */
    protected $adminUserService;
    
    
    /**
     * @param AdminUserService $adminUserService
     * @return void
     */
    public function __construct(AdminUserService $adminUserService)
    {
        parent::__construct();
        
        $this->adminUserService = $adminUserService;
    }
    
    
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('adminauth2:change-user-password')
             ->setDescription('Change a user\'s password.')
             ->addArgument('username', InputArgument::REQUIRED, 'Username');
    }
    
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminUserService = $this->adminUserService;
        $username         = $input->getArgument('username');
        
        $user = $adminUserService->getUserWithUsername($username);
        
        if (is_null($user)) {
            $output->writeln("User \"$username\" not found!");
            return;
        }
        
        $helper = $this->getHelper('question');
        $question = new Question("Enter new password for user \"$username\": ");
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $question);
        
        $user->setPassword($password);
        $adminUserService->save($user);
        
        $output->writeln("Password change complete.");
    }
}
