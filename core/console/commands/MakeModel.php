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
        $text = "";

        //$text = $this->controller();

        if ($name) {
            $message = $this->createModel($name);
            $output->writeln($message);
        } else {
            $text = "Please give a name for Model!";
        }

        $output->writeln($text);
    }

    protected function createModel($name)
    {
        $text;
        $fileName = "{$name}.php";
        $filePath = "app/" . $fileName;

        $fileContent = "<?php \r\n";
        $fileContent .= "namespace app; \r\n\r\n";
        $fileContent .= "use database\Model; \r\n\r\n";
        $fileContent .= "class {$name} extends Model \r\n{\r\n";
        $fileContent .= "\tprotected static \$table_name = \"" . strtolower($name) . "s\";\r\n";
        $fileContent .= "}";

        if (file_exists($filePath)) {
            $text = "Model {$name} Already Exists!";
        } else {
            if (file_put_contents($filePath, $fileContent) !== false) {
                $text = "Model {$name} created";
            } else {
                echo "Cannot create file (" . basename($filePath) . ").";
            }
        }

        return $text;
    }
}
