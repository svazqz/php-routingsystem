<?php

namespace App\Controllers;

use Core\Classes as Core;

class Home extends Core\Controller {

    public function index() {
        $mView = $this->getView();
        $mView->show("homePage");
    }

}
