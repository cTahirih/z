<?php
namespace AdminAuth2\Skelsus\Console\Command;

use AdminAuth2\Service\AdminUserService;
use AdminAuth2\Service\AdminRoleService;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CreateSuperUserCommand extends Command
{
    /**
     * @var AdminUserService
     */
    protected $adminUserService;
    
    /**
     * @var AdminRoleService
     */
    protected $adminRoleService;
    
    
    
    /**
     * @param AdminUserService $adminUserService
     * @param AdminRoleService $adminRoleService
     * @return void
     */
    public function __construct(
        AdminUserService $adminUserService,
        AdminRoleService $adminRoleService
    ) {
        parent::__construct();
        
        $this->adminUserService = $adminUserService;
        $this->adminRoleService = $adminRoleService;
    }
    
    
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('adminauth2:create-super-user')
             ->setDescription('Creates an AdminAuth2 super user.');
    }
    
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminUserService = $this->adminUserService;
        $adminRoleService = $this->adminRoleService;
        
        if ($adminUserService->existsSuperuser()) {
            $output->writeln("A super user already exists!");
            return;
        }
        
        $helper = $this->getHelper('question');
        $question = new Question('Enter password for new super user:');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $question);
        
        // Create the Admin role, or fetch if it already exists
        if ($adminRoleService->adminRoleExists()) {
            $adminRole = $adminRoleService->findRoleByName('Admin');
        } else {
            try {
                $adminRole = $adminRoleService->createAdminRole();
            }
            catch (RuntimeException $e) {
                $output->writeln('An error ocurred while creating "Admin" role.');
                $output->writeln('Exception message: ' . $e->getMessage());
                return;
            }
        }
        
        try {
            $adminUserService->createSuperuser($password);
        }
        catch (RuntimeException $e) {
            $output->writeln("An error ocurred while creating super user.");
            $output->writeln('Exception message: ' . $e->getMessage());
            return;
        }
        
        $output->writeln('');
        $output->writeln('Super user successfully created!');
        $output->writeln('Login with username "admin"');
    }
}
