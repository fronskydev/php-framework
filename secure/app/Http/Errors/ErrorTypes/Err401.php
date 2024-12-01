<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err401 extends Error
{
    public function __construct()
    {
        $description = [
            "The request requires user authentication.",
        ];

        parent::__construct(401, "Unauthorized", $description);
        $this->render();
        header("HTTP/1.1 401 Unauthorized");
    }
}