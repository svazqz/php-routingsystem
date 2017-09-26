<?php

namespace App\Controllers;

use Core\Classes as Core;
use Models as Model;

class Home extends Core\Controller {

    public function index() {
        $mView = $this->getView();
        $mView->show("homePage");
    }

    public function testModel() {
        $test =  new Model\Sample();
        $test->username = "dj_shuy";
        $test->name = "Jesus";
        $test->lastname = "Martinez";
        $test->save();
    }

}
