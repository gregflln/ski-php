<?php
namespace Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'ski:generate';

    protected static $defaultDescription = 'Create default files for Ski.';

    protected function configure():
        void
        {
            $this->setHelp('This command will create and generate files that you need to start yout Ski project');
            $this->addArgument('dirname', InputArgument::REQUIRED, 'Directory name for installation.');
            // ...

        }

        protected function execute(InputInterface $input, OutputInterface $output):
            int
            {
                // ... put here the code to create the user
                // this method must return an integer number with the "exit status code"
                // of the command. You can also use these constants to make code more readable
                $rootdir = $input->getArgument('dirname');

                if (file_exists($rootdir))
                {
                    echo "[security] Data loss prevention | The provided directory already exist, operation aborted";
                    return Command::SUCCESS;
                }
                $dir_need = ['/vues', '/components', '/layouts'];
                $files_need = ['/head.php', 'config.yaml'];

                function recurse_copy($src, $dst)
                {
                    $dir = opendir($src);
                    @mkdir($dst);
                    while (false !== ($file = readdir($dir)))
                    {
                        if (($file != '.') && ($file != '..'))
                        {
                            if (is_dir($src . '/' . $file))
                            {
                                recurse_copy($src . '/' . $file, $dst . '/' . $file);
                            }
                            else
                            {
                                copy($src . '/' . $file, $dst . '/' . $file);
                            }
                        }
                    }
                    closedir($dir);
                }
                //copy(__DIR__.'/Ressources/', $rootdir);
                recurse_copy(__DIR__ . '/Ressources/', $rootdir);
                return Command::SUCCESS;

                // or return this if some error happened during the execution
                // (it's equivalent to returning int(1))
                // return Command::FAILURE;
                // or return this to indicate incorrect command usage; e.g. invalid options
                // or missing arguments (it's equivalent to returning int(2))
                // return Command::INVALID

            }
        }
