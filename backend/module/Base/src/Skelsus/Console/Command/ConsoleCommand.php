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
class ConsoleCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('console')
             ->setDescription('Drops you into a <options=bold>psysh</> console. Nifty.');
    }
    
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        pcntl_exec('vendor/bin/psysh', ['--config', __DIR__ . '/../../../../psysh/psysh.config.php']);
    }
}
