<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err000 extends Error
{
    public function __construct(int $errorCode = 000)
    {
        $description = [
            "The requested error code has not been found.",
        ];

        parent::__construct($errorCode, "Error Not Found", $description);
        $this->render();
        header("HTTP/1.1 $errorCode Error Not Found");
    }
}
