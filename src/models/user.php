<?php

class UserModel
{
  public $username;
  public $password;
  function __construct( $username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT username, password FROM users');
    foreach ($req->fetchAll() as $item) {
      $list[] = new UserModel($item[0] ,$item[1]);
    }
    return $list;
  }
  static function checkuser($user)
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query("SELECT * FROM users WHERE username='".$user."'");
    foreach ($req->fetchAll() as $item) {
      $list += $item;
    }
    return $list;
  }
  static function insert($user, $pass)
  {
    $db = DB::getInstance();
    $db->query( "INSERT INTO users (username, password) VALUES ('$user','$pass')");
    return;
  }
  static function del($user)
  {
    $db = DB::getInstance();
    $db->query("DELETE FROM users WHERE username='".$user."'");
    $db->query("DELETE FROM ip WHERE username='".$user."'");
    return ;
  }
  static function list()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query("SELECT username FROM users");
    foreach ($req->fetchAll() as $item) {
      array_push($list,$item);
    }
    return $list;
  }
}