<?php

namespace app\Http\Objects;

class PageInfo
{
    public string $title = "";
    public array $styles = [];
    public array $scripts = [];
    public bool $bootstrapEnabled = true;
    public bool $headerEnabled = true;
    public bool $footerEnabled = true;
}