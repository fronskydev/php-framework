<?php

namespace bootstrap;

use app\Http\Controllers\MaintenanceController;
use app\Providers\RouteServiceProvider;
use Throwable;

class App
{
    /**
     * Run the application by loading routes, resolving the request, and handling errors.
     *
     * @return void
     */
    public function run(): void
    {
        if (isset($_ENV["APP_MAINTENANCE"]) && $_ENV["APP_MAINTENANCE"] === "true") {
            $maintenanceController = new MaintenanceController();
            $maintenanceController->index();
            exit();
        }

        $routeServiceProvider = new RouteServiceProvider();

        try {
            ob_start();
            $routeServiceProvider->loadRoutes(SECURE_DIR . "/routes/web.php");
            $errorCode = $routeServiceProvider->resolveRequest();
        }
        catch (Throwable $exception) {
            if (isset($_ENV["APP_ENV"]) && $_ENV["APP_ENV"] === "development") {
                ob_clean();
                echo $exception->getMessage();
                exit();
            }

            $errorCode = 500;
        }
        finally {
            if ($errorCode !== 200) {
                $routeServiceProvider->checkForErrors($errorCode);
            } else {
                $routeServiceProvider->checkForErrors(http_response_code());
            }
        }
    }
}
