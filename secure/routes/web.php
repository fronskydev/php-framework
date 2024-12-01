<?php
return [
    "/" => [
        "method" => "*",
        "action" => "HomeController@index"
    ],
    "/home" => [
        "method" => "GET",
        "action" => "HomeController@index"
    ],
];