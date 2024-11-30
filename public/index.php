<?php

// Include the autoloader file to load classes automatically
require_once __DIR__ . "/../secure/all_autoload.php";

// Create a new instance of the bootstrap\App class
$bootstrap = new bootstrap\App();

// Run the application by calling the 'run' method
$bootstrap->run();
