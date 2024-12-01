<?php

namespace app\Http\Errors;

class ErrorHandler
{
    /**
     * Handle the specified error code by loading the corresponding error page.
     *
     * @param int $errorCode The error code to be handled.
     *
     * @return void
     */
    public function handle(int $errorCode): void
    {
        $errorName = "Err$errorCode";

        if (class_exists("app\Http\Errors\ErrorTypes\\$errorName")) {
            $this->loadError($errorCode, $errorName);
        } else {
            $this->loadError($errorCode, "Err000");
        }
    }

    /**
     * Load and handle the error page for the specified error code and error class name.
     *
     * @param int $errorCode The error code to be handled.
     * @param string $errorName The name of the error class representing the specific error.
     *
     * @return void
     */
    private function loadError(int $errorCode, string $errorName): void
    {
        $errorClass = "app\Http\Errors\ErrorTypes\\$errorName";
        if (class_exists($errorClass)) {
            new $errorClass($errorCode);
            return;
        }

        http_response_code(500);
    }
}