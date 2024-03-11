<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

#[AsCommand(
    name: 'app:symfony-style',
    description: 'Styling Symfony CLI',
)]
class SymfonyStyleCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $items = ['apple', 'pear', 'pineapple', 'plum'];

        // $io->writeln('This is from writeln()');


        // /** Titling Methods */
        // $io->title('This is from section()');
        // $io->section('This is from title()');


        // /** Content Methods */
        // $io->text('This is from text()');
        // $io->text([
        //     'Lorem ipsum dolor sit amet',
        //     'Consectetur adipiscing elit',
        //     'Aenean sit amet arcu vitae sem faucibus porta',
        // ]);

        // $io->block([
        //     'This is from block() line 1',
        //     'This is from block() line 2',
        //     'This is from block() line 3',
        // ]);

        // $io->listing(['apple', 'pear', 'pineapple', 'plum']);

        // $io->table(['Location', 'Country'], [
        //     ['Barcelona', 'ES'],
        //     ['Belgrade', 'RS'],
        //     ['Paris', 'FR'],
        //     ['Athen', 'GR'],
        // ]);

        // $io->horizontalTable(['Location', 'Country'], [
        //     ['Barcelona', 'ES'],
        //     ['Belgrade', 'RS'],
        //     ['Paris', 'FR'],
        //     ['Athen', 'GR'],
        // ]);

        // $io->definitionList(
        //     'This is from definitionList()', 
        //     ['ES' => 'Spain'],
        //     ['RS' => 'Serbia'],
        //     ['FR' => 'France'],
        //     new TableSeparator(),
        //     'This is title from TableSeparator() class',
        //     ['GR' => 'Greece'],
        // );

        // // outputs a single blank line
        // $io->newLine();

        // // outputs three consecutive blank lines
        // $io->newLine(3);


        // /** Admonition Methods */
        // $io->note('This is a string from note()');
        // $io->note([
        //     'This is 1st element of an array from note()',
        //     'This is 2nd element of an array from note()',
        //     'This is 3rd element of an array from note()',
        // ]);

        // $io->caution('This is a string from caution()');
        // $io->caution([
        //     'This is 1st element of an array from caution()',
        //     'This is 2nd element of an array from caution()',
        //     'This is 3rd element of an array from caution()',
        // ]);


        // /** Progress Bar Methods */
        // $io->progressStart(max:4);
        // foreach($items as $anItem) { 
        //     $io->progressAdvance();
        //     // $io->newLine();
        //     // echo $anItem;
        //     sleep(2);
        // }
        // $io->progressFinish();


        /** User Input Methods */
        // $userNotRegistered = "Unregistered" . rand(100, 999);
        // $username = $io->ask("Enter username:", $userNotRegistered);
        // echo $username;

        // $io->askHidden("Enter your password:");
        // $io->confirm("Are you sure?");

        // $fruit = $io->choice("Choose fruit:", $items);
        // echo $fruit;

        // $fruits = $io->choice("Choose fruits: [multiple choices allowed]", $items, multiSelect:true);
        // foreach($fruits  as $singleFruit) {
        //     echo $singleFruit;
        //     $io->newLine();
        // }


        /** Result Methods */

        // $io->success('This is from success()');
        // $io->success([
        //     'This is 1st element of an array from success()',
        //     'This is 2nd element of an array from success()',
        //     'This is 3rd element of an array from success()',
        // ]);

        // $io->info('This is from info()');
        // $io->info([
        //     'This is 1st element of an array from info()',
        //     'This is 2nd element of an array from info()',
        //     'This is 3rd element of an array from info()',
        // ]);

        // $io->warning("This is from warning()");
        // $io->warning([
        //     'This is 1st element of an array from warning()',
        //     'This is 2nd element of an array from warning()',
        //     'This is 3rd element of an array from warning()',
        // ]);

        // $io->error("This is from error()");
        // $io->error([
        //     'This is 1st element of an array from error()',
        //     'This is 2nd element of an array from error()',
        //     'This is 3rd element of an array from error()',
        // ]);


        /** Colors **/
        // green text
        $output->writeln('<info>This text is inside info tag</info>');

        // yellow text
        $output->writeln('<comment>This text is inside comment tag</comment>');

        // black text on a cyan background
        $output->writeln('<question>This text is inside question tag</question>');

        // white text on a red background
        $output->writeln('<error>This text is inside error tag</error>');

        // custom style
        $outputStyle = new OutputFormatterStyle('red', '#fff', ['bold', 'underscore']);
        $output->getFormatter()->setStyle('izmisljenitag', $outputStyle);
        $output->writeln('<izmisljenitag>This is text inside a custom made style</>');

        // inside the tag name
        $io->writeln("<fg=white;bg=gray;options=bold,underscore>This style is set inside the tag name</>");


        //Displaying Clickable Links
        $output->writeln('<href=https://symfony.com>Symfony Homepage</>');

        return Command::SUCCESS;
    }
}
