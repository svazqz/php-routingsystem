<?php

namespace App\Views;

use Core\Classes as Core;

class Home extends Core\View {

    public function homePage() {
        $this->render("index");
    }

}
