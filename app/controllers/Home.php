<?php

namespace Controllers;

use Core;
use Models;

class Home extends Core\Controller {

    public function index() {
        $mView = $this->getView();
        $mView->show("homePage");
    }

    public function test($var = "ok", $var2 = "ok") {
        echo $var." ".$var2;
    }

    public function testModel() {
        $test =  new Models\Test();
        $test->username = "shequito";
        $test->name = "Sergio";
        $test->lastname = "Vázquez";
        $test->save();
    }

}
