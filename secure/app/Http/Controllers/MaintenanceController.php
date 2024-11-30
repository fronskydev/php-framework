<?php

namespace app\Http\Controllers;

class MaintenanceController
{
    public function index(): void
    {
        require_once SECURE_DIR . "/resources/view/maintenance.php";
    }
}