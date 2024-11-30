<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err400 extends Error
{
    public function __construct()
    {
        $description = [
            "The server could not understand the request due to invalid syntax or missing parameters.",
        ];

        parent::__construct(400, "Bad Request", $description);
        $this->render();
        header("HTTP/1.1 400 Bad Request");
    }
}