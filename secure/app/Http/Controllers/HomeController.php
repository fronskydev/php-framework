<?php

namespace app\Http\Controllers;

use app\Http\Objects\PageInfo;

class HomeController extends Controller
{
    public function index(): void
    {
        $pageInfo = new PageInfo();
        $pageInfo->title = "Fronsky® PHP Framework | Home";

        $this->renderView("welcome", pageInfo: $pageInfo);
    }
}