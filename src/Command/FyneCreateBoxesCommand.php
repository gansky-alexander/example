<?php

namespace App\Command;

use App\Model\BoxModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FyneCreateBoxesCommand extends Command
{
    protected static $defaultName = 'fyne:create-boxes';

    private $boxModel;

    public function __construct(BoxModel $boxModel)
    {
        $this->boxModel = $boxModel;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Generates empty boxes for customers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->boxModel->generateBoxes(new \DateTime());

        $io->success('All boxes was successfully generated');

        return 0;
    }
}
