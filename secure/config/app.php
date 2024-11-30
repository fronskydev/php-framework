<?php

// Set the default timezone for date and time functions to "Europe/Amsterdam"
date_default_timezone_set("Europe/Amsterdam");

// Check if the connection is secure (HTTPS) and set the $isSecure variable accordingly
$isSecure = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on";

// Set error reporting to display all errors
error_reporting(E_ALL);

// Retrieve the current URL
$currentURL = "http" . ($isSecure ? "s" : "") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

// Parse the base URL from the current request
$baseUrlParts = parse_url("http" . ($isSecure ? "s" : "") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
$baseUrl = $baseUrlParts["scheme"] . "://" . $baseUrlParts["host"];
$rootURL = $baseUrl;

// If the application environment is set to "development"
if (isset($_ENV["APP_ENV"]) && $_ENV["APP_ENV"] === "development") {
    // Get the application name from the environment variables
    $appName = $_ENV["APP_NAME"] ?? "";

    // Append the application name to the root URL and "/public" to the base URL
    $baseUrl .= "/" . $appName . "/public";
    $rootURL .= "/" . $appName;

    // Enable the display of PHP errors for development environment
    ini_set("display_errors", 1);
} else {
    // Disable the display of PHP errors for other environments (e.g., production)
    ini_set("display_errors", 0);
}

// Define constant "APP_ENV" with the value from the environment variables or use "development" as the default
define("APP_ENV", $_ENV["APP_ENV"] ?? "development");

// Define constant "CURRENT_URL" with the current URL
define("CURRENT_URL", $currentURL);

// Define constant "IS_MOBILE" with the value indicating whether the current request is from a mobile device
define("IS_MOBILE", preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]));

// Define constant "PUBLIC_URL" with the base URL for the public directory
define("PUBLIC_URL", $baseUrl);

// Define constant "ROOT_URL" with the root URL of the application
define("ROOT_URL", $rootURL);
