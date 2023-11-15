<?php

use Core\Main\Config\App;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App();
$app();