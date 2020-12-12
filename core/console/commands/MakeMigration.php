<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMigration extends Command
{
    protected $commandName = 'make:migration';
    protected $commandDescription = "Makes a migration";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = " ";


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
        $name = $input->getArgument($this->commandArgumentName);
        $text = "";

        $fileContent;
        $templateFilePath = "core/console/templates/migration.txt";
        
        $myfile = fopen($templateFilePath, "r") or die("Unable to open file!");
        $fileContent = fread($myfile, filesize($templateFilePath));
        fclose($myfile);

        $fileContent = str_replace('given_name', $name, $fileContent);
        $fileName = "{$name}migration.php";
        $filePath = "app/migrations/" . $fileName;

        if (file_exists($filePath)) {
            $text = "{$name}migration Already Exists!";
        } else {
            if (file_put_contents($filePath, $fileContent) !== false) {
                $text = "{$name}migration created";
            } else {
                echo "Cannot create file (" . basename($filePath) . ").";
            }
        }

        $output->writeln($text);
    }

}
