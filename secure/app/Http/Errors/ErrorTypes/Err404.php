<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err404 extends Error
{
    public function __construct()
    {
        $description = [
            "The page you are looking for could not be found. It may have been removed, had its name changed, or is temporarily unavailable.",

        ];

        parent::__construct(404, "Page Not Found", $description);
        $this->render();
        header("HTTP/1.1 404 Page Not Found");
    }
}