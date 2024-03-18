<?php

namespace App\Command;

use App\Service\Highlander;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'highlander:say',
    description: 'Add a short description for your command',
)]
class HighlanderSayCommand extends Command
{
    public function __construct(
        private Highlander $highlander,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(name:'threshold', shortcut: 't', mode:InputOption::VALUE_REQUIRED, description:"Threshold for the weather")
            ->addOption(name:'trials', shortcut:'r', mode:InputOption::VALUE_REQUIRED, description:'Number of forecast results')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $threshold = $input->getOption('threshold');
        $trials = $input->getOption('trials');

        $forecasts = $this->highlander->say(threshold: $threshold, trial: $trials);
        
        $io->listing($forecasts);

        return Command::SUCCESS;
    }
}
