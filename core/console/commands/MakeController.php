<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeController extends Command
{
    protected $commandName = 'make:controller';
    protected $commandDescription = "Makes a controller";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = " ";

    protected $commandOptionName = "resource";
    protected $commandOptionShort = "r";
    protected $commandOptionDescription = 'Will create resources in controller';

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
            ->addOption(
                $this->commandOptionName,
                $this->commandOptionShort,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);
        $option_resource = $input->getOption($this->commandOptionName);
        $text = "";

        $fileContent;
        $templateFilePath = $option_resource ? "core/console/templates/controller_resource.txt" : "core/console/templates/controller.txt";
        
        $myfile = fopen($templateFilePath, "r") or die("Unable to open file!");
        $fileContent = fread($myfile, filesize($templateFilePath));
        fclose($myfile);

        $fileContent = str_replace('given_name', $name, $fileContent);
        $fileName = "{$name}Controller.php";
        $filePath = "app/controllers/" . $fileName;

        if (file_exists($filePath)) {
            $text = "{$name}Controller Already Exists!";
        } else {
            if (file_put_contents($filePath, $fileContent) !== false) {
                $text = "{$name}Controller created";
            } else {
                echo "Cannot create file (" . basename($filePath) . ").";
            }
        }

        $output->writeln($text);
    }

}
