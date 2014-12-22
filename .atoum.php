<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .
             'vendor' . DIRECTORY_SEPARATOR .
             'autoload.php';

use Atoum\HttpExtension;

$runner->addExtension(new HttpExtension\Manifest());
$runner->addTestsFromDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'Test');
