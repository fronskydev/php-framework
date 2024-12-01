<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err403 extends Error
{
    public function __construct()
    {
        $description = [
            "The server understood the request, but is refusing to fulfill it due to lack of permissions.",
        ];

        parent::__construct(403, "Forbidden", $description);
        $this->render();
        header("HTTP/1.1 403 Forbidden");
    }
}