<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err502 extends Error
{
    public function __construct()
    {
        $description = [
            "The server received an invalid response from the upstream server.",
        ];

        parent::__construct(502, "Bad Gateway", $description);
        $this->render();
        header("HTTP/1.1 502 Bad Gateway");
    }
}