<?php

namespace app\Http\Errors;

class Error
{
    private int $number;
    private string $title;
    private array $description;

    /**
     * Constructor of the class.
     *
     * @param int $number The error number/code.
     * @param string $title The title/description of the error.
     * @param array $description An array containing a detailed description of the error.
     */
    public function __construct(int $number, string $title, array $description)
    {
        $this->number = $number;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Render the error page with the provided data.
     *
     * @return void
     */
    public final function render(): void
    {
        $number = $this->number;
        $title = $this->title;
        $description = $this->description;

        require_once SECURE_DIR . "/resources/view/shared/error.php";
    }
}