<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err304 extends Error
{
    public function __construct()
    {
        $description = [
            "The resource has not been modified since the last time it was requested.",
        ];

        parent::__construct(304, "Not Modified", $description);
        $this->render();
        header("HTTP/1.1 304 Not Modified");
    }
}