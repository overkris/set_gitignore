#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Command\SetGitIgnore;
use Composer\Autoload\ClassLoader;
use Symfony\Component\Console\Application;

define("APP_ROOT", __DIR__);

$loader = new ClassLoader();
$loader->add('Command', __DIR__.'/');
$loader->register();

$application = new Application();
$application->add(new SetGitIgnore());
$application->run();
