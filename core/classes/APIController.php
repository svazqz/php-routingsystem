<?php

namespace Core;

abstract class APIController {

  private const __HTTP_VERBS__ = array(
    "POST" => "create",
    "GET" => "show",
    "PUT" => "update",
    "DELETE" => "delete"
  );

  public function __construct($components = array()) {
    call_user_func_array(array($this, self::__HTTP_VERBS__[$_SERVER["REQUEST_METHOD"]]), $components);
  }

  public function show() {
    echo "Executed GET";
  }
  public function create() {
    echo "Executed POST";
  }
  public function update() {
    echo "Executed PUT";
  }
  public function delete() {
    echo "Executed DELETE";
  }

}
