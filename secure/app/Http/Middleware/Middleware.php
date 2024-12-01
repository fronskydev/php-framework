<?php

namespace app\Http\Middleware;

abstract class Middleware
{
    /**
     * Handle the middleware logic.
     *
     * @return void
     */
    abstract public function handle(): void;

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

                    Object.entries(" . json_encode($postData) . ").forEach(([key, value]) => {
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
