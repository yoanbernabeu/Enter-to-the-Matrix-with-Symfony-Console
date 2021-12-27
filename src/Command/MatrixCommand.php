<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Service\MatrixService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

class MatrixCommand extends Command
{
    private MatrixService $matrixService;

    public function __construct(MatrixService $matrixService)
    {
        $this->matrixService = $matrixService;

        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:matrix';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Initialize Terminal
        $terminal = new Terminal;
        $width = $terminal->getWidth();
        $height = $terminal->getHeight();
        $cursor = new Cursor($output);
        $cursor->hide();

        // Print Welcome Message
        $cursor->clearScreen();
        $cursor->moveToPosition(0, 0);
        $output->writeln('<fg=green;options=bold>Welcome to the Matrix ...</>');
        sleep(3);

        // Initialize Matrix
        $cursor->clearScreen();
        $initLine = $this->matrixService->initMatrix($width);
        $arrayLine = $this->matrixService->makeArrayLine($width, $height, $initLine);
        
        // Make matrix
        $x = 0;
        while (true) {
            $a = 0;
            while ($a < $width - 1) {
                $a++;
                $cursor->moveToPosition($arrayLine[$a]['col'], $arrayLine[$a]['row']);
                $output->write('<fg=green;options=bold>'.$arrayLine[$a]['string'].'</>');
            }
            $x++;
            usleep(60000);
            $arrayLine = $this->matrixService->makeArrayLine($width, $height, $arrayLine);
        }

        return Command::SUCCESS;
    }
}