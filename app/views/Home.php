<?php

namespace Views;

class Home {

  public function homePage() {
    echo \Input::getVar("name", "Name");
  }

}
