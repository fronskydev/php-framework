<?php

// Load the Composer autoloader to automatically load required classes.
require_once __DIR__ . "/vendor/autoload.php";

// Load the functions file.
require_once __DIR__ . '/config/functions.php';

// Define the base directory path for the secure directory.
define("SECURE_DIR", realpath(__DIR__));

// Register an autoloader function to load classes when needed.
spl_autoload_register(static function ($class) {
    $baseDir = SECURE_DIR;

    // Convert the namespace separator (\) to a directory separator (/) in the class name.
    $fileName = str_replace("\\", "/", $class) . ".php";

    // Construct the full file path by combining the base directory with the class file name.
    $filePath = $baseDir . "/" . $fileName;

    // If the file exists, require it to load the class definition.
    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        // If the file does not exist, search for the class in all subdirectories of the base directory.
        $dirIterator = new RecursiveDirectoryIterator($baseDir);
        $iterator = new RecursiveIteratorIterator(
            $dirIterator,
            RecursiveIteratorIterator::SELF_FIRST
        );

        // Iterate through each file in the subdirectories.
        foreach ($iterator as $file) {
            // Check if the file contains the desired class name.
            if (str_contains($file, $fileName)) {
                // If found, require the file to load the class definition and stop the iteration.
                require_once $file;
                break;
            }
        }
    }
});

// Load environment variables from the .env file in the 'config' directory.
$dotenv = Dotenv\Dotenv::createImmutable(SECURE_DIR . "/config/");
$dotenv->safeLoad();

// Include the application configuration file.
require_once __DIR__ . "/config/app.php";
