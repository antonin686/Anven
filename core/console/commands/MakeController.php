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

        if ($name) {

            if ($option_resource) {

                $fileContent = "<?php \r\n";
                $fileContent .= "namespace app\controllers;\r\n\r\n";
                $fileContent .= "use app\controllers\Controller; \r\n\r\n";
                $fileContent .= "class {$name}Controller extends Controller\r\n{\r\n";
                //Index Function
                $fileContent .= "\t/**\r\n\t * Display listing of the resource\r\n";
                $fileContent .= "\t * @Return JSON data\r\n\t */\r\n";
                $fileContent .= "\tpublic function index()\r\n\t{\r\n";
                $fileContent .= "\t\t\r\n";
                $fileContent .= "\t}\r\n\r\n";
                //Create Function
                $fileContent .= "\t/**\r\n\t * Create a new resourse\r\n";
                $fileContent .= "\t * @Return JSON data\r\n\t */\r\n";
                $fileContent .= "\tpublic function create(\$request)\r\n\t{\r\n";
                $fileContent .= "\t\t\r\n";
                $fileContent .= "\t}\r\n\r\n";
                //Show Function
                $fileContent .= "\t/**\r\n\t * Display the specified resource\r\n";
                $fileContent .= "\t * @Return JSON data\r\n\t */\r\n";
                $fileContent .= "\tpublic function show(\$id)\r\n\t{\r\n";
                $fileContent .= "\t\t\r\n";
                $fileContent .= "\t}\r\n\r\n";
                //Update Function
                $fileContent .= "\t/**\r\n\t * Update the specified resource\r\n";
                $fileContent .= "\t * @Return JSON data\r\n\t */\r\n";
                $fileContent .= "\tpublic function update(\$id, \$request)\r\n\t{\r\n";
                $fileContent .= "\t\t\r\n";
                $fileContent .= "\t}\r\n\r\n";        
                //Delete Function
                $fileContent .= "\t/**\r\n\t * Remove the specified resource\r\n";
                $fileContent .= "\t * @Return JSON data\r\n\t */\r\n";
                $fileContent .= "\tpublic function delete(\$id)\r\n\t{\r\n";
                $fileContent .= "\t\t\r\n";
                $fileContent .= "\t}\r\n\r\n";

                $fileContent .= "}";

            } else {
                $fileContent = "<?php \r\n";
                $fileContent .= "use app\controllers\Controller; \r\n\r\n";
                $fileContent .= "class {$name}Controller extends Controller {\r\n\r\n    \r\n\r\n";
                $fileContent .= "}";
            }

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

        } else {
            $text = 'Please give a name for the controller!';
        }

        $output->writeln($text);
    }
}
