<?php 

require_once __DIR__ . '/lib/ClassLoader.php';

// Loader
ClassLoader::regLibrary(__DIR__);
ClassLoader::regLibrary(__DIR__ . "/lib");

spl_autoload_register(array("ClassLoader", "loadClass"));

