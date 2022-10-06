<?php

class ipModel
{
  public $ip;
  public $username;
  function __construct( $ip, $username)
  {
    $this->ip = $ip;
    $this->username = $username;
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT ip, username FROM ip');
    foreach ($req->fetchAll() as $item) {
      $list[] = new ipModel($item[0] ,$item[1]);
    }
    return $list;
  }
  static function insert($ip_ins, $user_ins)
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query( "INSERT INTO ip (ip, username) VALUES ('$ip_ins','$user_ins')");
    return ;
  }
  static function iplistadmin()
  {
    $list = array();
    $db = DB::getInstance();
    $req = $db->query('SELECT ip FROM ip');
    foreach ($req->fetchAll() as $item) {
      array_push($list,$item[0]);
    }
    return $list;
  }
  static function iplistuser($user)
  {
    $list = array();
    $db = DB::getInstance();
    $req = $db->query("SELECT ip FROM ip WHERE username = '".$user."'");
    foreach ($req->fetchAll() as $item) {
      array_push($list,$item[0]);
    }
    return $list;
  }
}