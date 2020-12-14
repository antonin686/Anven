<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModel extends Command
{
    protected $commandName = 'make:model';
    protected $commandDescription = "Makes a model";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = " ";

    protected $commandOptionName = "migrate";
    protected $commandOptionShort = "m";
    protected $commandOptionDescription = 'Will create a migration file';

    protected $commandOptionName2 = "controller";
    protected $commandOptionShort2 = "c";
    protected $commandOptionDescription2 = 'Will create a controller file';

    protected $commandOptionName3 = "resource";
    protected $commandOptionShort3 = "r";
    protected $commandOptionDescription3 = 'Will create resources in controller';

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
            ->addOption(
                $this->commandOptionName2,
                $this->commandOptionShort2,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription2
            )
            ->addOption(
                $this->commandOptionName3,
                $this->commandOptionShort3,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription3
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);
        $option_migration = $input->getOption($this->commandOptionName);
        $option_controller = $input->getOption($this->commandOptionName2);
        $option_resource = $input->getOption($this->commandOptionName3);
        $text = $fileContent = $templateFilePath = "";

        //Create Model
        $templateFilePath = "core/console/templates/model.txt";
        $myfile = fopen($templateFilePath, "r") or die("Unable to open file!");
        $fileContent = fread($myfile, filesize($templateFilePath));
        fclose($myfile);

        $vowels = ['a', 'e', 'i', 'o', 'u'];
        $table_name = substr($name, -1) == 'y' && !in_array(substr($name, -2, 1), $vowels) ? substr($name, 0, -1) . "ies" : "{$name}s";

        $fileContent = str_replace('given_name', $name, $fileContent);
        $fileContent = str_replace('given_table_name', strtolower($table_name), $fileContent);
        $fileName = "{$name}.php";
        $filePath = "app/" . $fileName;

        if (file_exists($filePath)) {
            $text = "Model {$name} Already Exists!";
        } else {
            if (file_put_contents($filePath, $fileContent) !== false) {
                $text = "Model {$name} created";
            } else {
                echo "Cannot create file (" . basename($filePath) . ").";
            }
        }

        $output->writeln($text);

        //Create Controller

        if ($option_controller) {
            $templateFilePath = $option_resource ? "core/console/templates/controller_resource_model.txt" : "core/console/templates/controller_model.txt";
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

        //Create Migration

        
    }

}
