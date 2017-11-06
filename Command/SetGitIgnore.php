<?php
/**
 * Created by PhpStorm.
 * User: cbeuffre
 * Date: 21/09/2017
 * Time: 13:32
 */
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;


class SetGitIgnore extends Command
{
    /**
     * Configure de la commande
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('setGitIgnore')
            ->setDescription("Set d'un fichier gitignore dans tous les dossier vide")
            ->addArgument('path_rep', InputArgument::REQUIRED, 'Le rep du dossier');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get du path du rep
        $pathRep = $input->getArgument('path_rep');

        $fs = new Filesystem();
        $finder = new Finder();
        $finder->directories()->in($pathRep);

        $output->writeln("Set du git Ignore dans les dossiers suivants: ");
        foreach ($finder as $file) {
            if ($this->dirIsEmpty($file->getRealPath()) == 2) {
                $output->writeln($file->getRealPath());
                $fs->copy(APP_ROOT.'/conf/.gitignore', $file->getRealPath()."/.gitignore");
            }
        }
    }

    protected function dirIsEmpty($dir) {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }
}