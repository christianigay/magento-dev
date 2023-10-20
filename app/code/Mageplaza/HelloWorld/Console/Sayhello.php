<?php
namespace Mageplaza\HelloWorld\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Sayhello extends Command
{

    const NAME = 'name';


    protected function configure()
    {
        $options = [
            new InputOption(self::NAME, null,InputOption::VALUE_REQUIRED, 'Name')
        ];
        $this->setName('example:sayhello')
            ->setDescription('Demo command line')
            ->setDefinition($options);
        
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption(self::NAME);
        $name 
            ? $output->writeln('Hello ' . $name) 
            : $output->writeln("Hello World command");
        return 1;
    }
}