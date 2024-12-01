<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err302 extends Error
{
    public function __construct()
    {
        $description = [
            "The requested resource has been temporarily moved to a different URL.",
        ];

        parent::__construct(302, "Found", $description);
        $this->render();
        header("HTTP/1.1 302 Found");
    }
}