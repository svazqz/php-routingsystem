<?php

namespace Views;

class Home {

    public function homePage() {
        //$this->render("index", array("name" => "Sergio"));
        echo \Input::getVar("name", "Beto");
    }

}
