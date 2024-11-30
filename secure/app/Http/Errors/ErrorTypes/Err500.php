<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err500 extends Error
{
    public function __construct()
    {
        $description = [
            "The server encountered an unexpected condition that prevented it from fulfilling the request.",
        ];

        parent::__construct(500, "Internal Server Error", $description);
        $this->render();
        header("HTTP/1.1 500 Internal Server Error");
    }
}