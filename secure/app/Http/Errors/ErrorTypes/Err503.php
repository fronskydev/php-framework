<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err503 extends Error
{
    public function __construct()
    {
        $description = [
            "The server is currently unavailable due to maintenance or overload.",
        ];

        parent::__construct(503, "Service Unavailable", $description);
        $this->render();
        header("HTTP/1.1 503 Service Unavailable");
    }
}