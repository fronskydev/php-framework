<?php

namespace app\Http\Errors\ErrorTypes;

use app\Http\Errors\Error;

class Err201 extends Error
{
    public function __construct()
    {
        $description = [
            "The request has been fulfilled and a new resource has been created.",
        ];

        parent::__construct(201, "Created", $description);
        $this->render();
        header("HTTP/1.1 201 Created");
    }
}