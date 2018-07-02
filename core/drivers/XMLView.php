<?php

namespace Drivers;

use Core;

class XMLView {
    public static function render($template = null, $data = null) {
        Core\TemplateEngine::render($template.".xml", $data, "application/xml");
    }
}
