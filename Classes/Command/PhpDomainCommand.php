<?php
namespace T3docs\RestructuredApiTools\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use T3docs\RestructuredApiTools\Util\ClassDocsHelper;

class PhpDomainCommand extends Command
{
    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setHelp('Prints a list of recent sys_log entries.'
            . LF . 'If you want to get more detailed information, use the --verbose option.')
            ->setDescription('Run content importer. Without '
                . ' arguments all available wizards will be run.')
            ->addArgument(
                'fullyQuallyfiedName',
                InputArgument::OPTIONAL,
                'Enter the fully qualified name of the structure you want to export'
            )
            ->addOption(
                'brute-force',
                'b',
                InputOption::VALUE_OPTIONAL,
                'Some optional option for your wizard(s). You '
                . 'can use --brute-force or -b when running command'
            );
    }

    /**
     * Executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $output = '';

        if ($input->getArgument('fullyQuallyfiedName')) {
            $output = ClassDocsHelper::extractDocsFromClass($input->getArgument('fullyQuallyfiedName'));
            //$output = $input->getArgument('fullyQuallyfiedName');
        } else {
            $output = 'Please enter the fully qualified name of the class or interface you want to document.';
        }

        $io->writeln('.. Generated by https://github.com/linawolf/t3docs_restructured_api_tools ' . LF . $output);
        return Command::SUCCESS;
    }
}
