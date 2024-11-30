<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err204 extends Error
{
    public function __construct()
    {
        $description = [
            "The server successfully processed the request, but is not returning any content.",
        ];

        parent::__construct(204, "No Content", $description);
        $this->render();
        header("HTTP/1.1 204 No Content");
    }
}