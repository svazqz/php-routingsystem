<?php

namespace Controllers;

use Core;
use Models;

class Home extends Core\Controller {

  public function main($n = "Your Name") {
    \View::renderHTML("home/index", array("name" => $n));
  }

  public function test($var = "ok", $var2 = "ok") {
    echo $var." ".$var2;
  }

  public function testView() {
    $this->getView()->homePage();
  }

  public function testModel() {
    $test =  new Models\Test();
    $test->username = "username";
    $test->name = "Firstname";
    $test->lastname = "Lastname";
    $test->save();
  }

}
