<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-command',
    description: 'This is a custom command, made from CLI',
)]
class TestCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument(name: "username", mode:InputArgument::OPTIONAL, description: "Name of a user", default: "User");

        // $this->
        //     addOption(name: 'username', shortcut: 'u', mode: InputOption::VALUE_OPTIONAL, description: 'Name of an user to greet', default: "user");

        $this->
            addOption(
                name: 'username', 
                shortcut: 'u', 
                mode: InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 
                description: 'Name of an user to greet');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $output->writeln([
        //     "This is a message!",
        //     "Another line!",
        // ]);

        // $output->write([
        //     "Single ",
        //     "line ",
        //     "message!",
        // ]);

        // $username = $input->getArgument('username');
        $username = $input->getOption('username');
        // $output->write("Welcome back, $username!");
        $output->write("Welcome back, " . implode(separator:', ', array:$username) . "!");

        return Command::SUCCESS;
    }
}
