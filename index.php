<?php 

use System\Route;
require_once __DIR__ . '/loader.php';

$app = new Route(__DIR__ . '/lib/App');

$app->run();

