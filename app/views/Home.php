<?php

namespace Views;

use Core;

class Home extends Core\View {

    public function homePage() {
        $this->render("index", array("name" => "Sergio"));
    }

}
