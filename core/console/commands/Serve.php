<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Serve extends Command
{
    protected $commandName = 'serve';
    protected $commandDescription = "Creates a development server";

    protected $commandArgumentName = "port";
    protected $commandArgumentDescription = "give port number";

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument($this->commandArgumentName);

        if(!$port){
            $port = 7000;
        }

        $text = shell_exec("php -S localhost:{$port}");

        $output->writeln($text);
    }
}
