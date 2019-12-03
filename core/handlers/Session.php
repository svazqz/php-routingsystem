<?php

namespace Handlers;

use Models;

class Session {

  protected $table = 'sessions';

  public function open() {
    return true;
  }

  public function close() {
    return true;
  }

  public function read($id) {
    $session = Models\Session::find_by_id($id);
    if( $session ) {
      return $session->data;
    } else {
      return false;
    }
  }

  public function write($id, $data) {
    $session = Models\Session::find_by_id($id);
    if( $session ){
      $session->data = $data;
      $session->save();
      return true;
    } else {
      $session = Models\Session::create(
            array(
              "id" => $id,
              "data" => $data
            )
          );
    }
    return false;
  }

  public function destroy($id) {
    $session = Models\Session::find_by_id($id);
    if( $session )
      $session->delete();
    return true;
  }

  public function gc($max) {
    $query = sprintf("DELETE FROM %s WHERE `created_at` < '%s'", $this->table, time() - intval($max));
    return dbDriver::execQuery($query);
  }

}
