<?php

namespace Drivers;

use Core;

class HTMLView {
    public static function render($template = null, $data = null) {
        Core\TemplateEngine::render($template.".json", $data, "application/json");
    }
}
