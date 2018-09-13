<?php
namespace Base\Skelsus\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @see Command
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DatabaseCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('database')
             ->setDescription('Drops you into the database console. Only MySQL is supported.');
    }
    
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $databaseConfig = 'config/autoload/database.php';
        
        if (!file_exists($databaseConfig)) {
            $output->writeLn('No database configuration file found. Aborting.');
            return;
        }
        
        $db = include $databaseConfig;
        
        if ($db['type'] !== 'mysql') {
            $output->writeLn(sprintf('Only MySQL is currently supported. Database configuration specifies: %s', $db['type']));
        }
        
        $output->writeLn(sprintf('<fg=yellow>Dropping to database, connecting to: "%s"</>', $db['database']));
        $output->writeLn('');
        
        pcntl_exec('/usr/bin/env', ['mysql', '--default-character-set=utf8', '-h', $db['host'], '-u', $db['username'], '-p' . $db['password'], '-P', $db['port'], $db['database']]);
    }
}
