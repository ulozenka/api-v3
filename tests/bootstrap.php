<?php

require __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
    echo 'Install Nette Tester using `composer update --dev`' . PHP_EOL;
    exit(1);
}

Tester\Environment::setup();
