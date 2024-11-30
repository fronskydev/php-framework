<?php

namespace app\Http\Controllers;

use app\Http\Objects\PageInfo;
use JsonException;

abstract class Controller
{
    protected string $viewPath;

    /**
     * Constructor of the class.
     *
     * Initializes the viewPath property with the path to the view resources directory.
     */
    public function __construct()
    {
        $this->viewPath = SECURE_DIR . "/resources/view";
    }

    /**
     * Render the specified view along with the optional data and page information.
     *
     * @param string $viewName The name of the view to be rendered (without the .php extension).
     * @param array $data An associative array containing data that will be extracted and made available to the view.
     * @param PageInfo $pageInfo An optional PageInfo object containing title, styles, and scripts for the page.
     *
     * @return void
     */
    protected function renderView(string $viewName, array $data = [], PageInfo $pageInfo = new PageInfo()): void
    {
        $viewFile = $this->viewPath . "/$viewName.php";
        $headerFile = $this->viewPath . "/shared/header.php";
        $footerFile = $this->viewPath . "/shared/footer.php";
        $layoutFile = $this->viewPath . "/shared/layout.php";

        if (!file_exists($viewFile)) {
            http_response_code(500);
            return;
        }

        extract($data);
        $title = (isset($pageInfo->title) && $pageInfo->title === "") ? ucfirst(strtolower($viewName)) : $pageInfo->title;
        $styles = $pageInfo->styles;
        $scripts = $pageInfo->scripts;
        $bootstrapEnabled = $pageInfo->bootstrapEnabled;

        if (file_exists($layoutFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();

            if ($pageInfo->headerEnabled && file_exists($headerFile)) {
                ob_start();
                require_once $headerFile;
                $header = ob_get_clean();
            }

            if ($pageInfo->footerEnabled && file_exists($footerFile)) {
                ob_start();
                require_once $footerFile;
                $footer = ob_get_clean();
            }

            require_once $layoutFile;
            return;
        }

        require_once $viewFile;
    }

    /**
     * Sends a JSON response to the client.
     *
     * @param mixed $data The data to be encoded as JSON and sent to the client.
     *
     * @throws JsonException If the data can't be encoded to JSON.
     *
     * @return void
     */
    protected function jsonResponse(mixed $data): void
    {
        header("Content-Type: application/json");
        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * Redirect to the specified URL with optional POST data.
     *
     * @param string $url The relative URL to which the redirect should occur.
     * @param array|null $postData An optional associative array containing POST data to be sent with the redirect.
     *
     * @return void
     */
    protected function redirect(string $url, ?array $postData = null): void
    {
        $newUrl = PUBLIC_URL . $url;

        if ($postData !== null) {
            echo "
                <script>
                function redirectWithPost() {
                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = '{$newUrl}';

                    Object.entries(" . json_encode($postData, JSON_THROW_ON_ERROR) . ").forEach(([key, value]) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
                window.onload = redirectWithPost;
                </script>
            ";
        } else {
            header("Location: $newUrl");
            exit();
        }
    }
}
