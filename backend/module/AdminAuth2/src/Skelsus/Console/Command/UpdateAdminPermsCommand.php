<?php
namespace AdminAuth2\Skelsus\Console\Command;

use AdminAuth2\Service\AdminRoleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class UpdateAdminPermsCommand extends Command
{
    /**
     * @var AdminRoleService
     */
    protected $adminRoleService;
    
    
    /**
     * @param AdminRoleService $adminRoleService
     * @return void
     */
    public function __construct(
        AdminRoleService $adminRoleService
    ) {
        parent::__construct();
        
        $this->adminRoleService = $adminRoleService;
    }
    
    
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('adminauth2:update-admin-perms')
             ->setDescription('Update the Admin role\'s permissions.');
    }
    
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->adminRoleService->assignAllResourcesToAdminRole();
        
        $output->writeln('Updated "admin" role with current permissions.');
    }
}
