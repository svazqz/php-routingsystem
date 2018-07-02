<?php

class HTMLView {
    public static function render($template = null, $data = null) {
        Core\TemplateEngine::render($template.".html", $data, "text/html");
    }
}
