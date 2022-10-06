<?php
session_start();
require_once('controllers/base_controller.php');
require('models/user.php');
require('models/ip.php');
class PagesController extends BaseController
{
  function __construct()
  {
    $this->folder = 'pages';
  }

  public function home()
  {
    if (isset($_SESSION['user'])) {
      $this->render('home');
    } else {
      $this->render('home');
    }
  }
  public function login()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $users =  UserModel::all();
      $username = $_POST['username'];
      $password = $_POST['password'];

      $exists = false;
      foreach ($users as $user) {
        if ($user == new UserModel($username, $password)) {
          $exists = true;
          break;
        }
      }
      if ($exists > 0) //IF there are no returning rows or no existing username
      {
        $_SESSION['user'] = $username;    // set the username in a session. 
        header("location: index.php");
      } else {
        print '<script>alert("Incorrect Username or Password!");</script>';        // Prompts the user
        print '<script>window.location.assign("index.php?controller=pages&action=login");</script>'; // redirects to login.php
      }
    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $this->render('login');
    }
  }
  public function register()
  {
    $connection = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $users = UserModel::checkuser($username);
      if (!$users) {
        UserModel::insert($username, $password);
        print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
        print '<script>window.location.assign("index.php?controller=pages&action=login");</script>'; // redirects to register.php
      } else {
        print '<script>alert("Username have been taken!");</script>'; // Prompts the user
        print '<script>window.location.assign("index.php?controller=pages&action=home");</script>'; // redirects to register.php
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $this->render('home');
    }
  }

  public function upload()
  {
    if (isset($_SESSION['user'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $this->render('upload');
      } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_SERVER["CONTENT_TYPE"] == 'application/x-www-form-urlencoded') {
          ipModel::insert($_POST['ipaddress'], $_SESSION['user']);
          print '<script>alert("Upload OK");</script>';        // Prompts the user
          print '<script>window.location.assign("index.php?controller=pages&action=upload");</script>'; // redirects to login.php
        } else if (strpos($_SERVER["CONTENT_TYPE"], 'multipart/form-data') !== false) {
          $lines = explode("\r\n", file_get_contents($_FILES['fileToUpload']['tmp_name']));
          foreach ($lines as $line) {
            ipModel::insert($line, $_SESSION['user']);
          }
          print '<script>alert("Upload OK");</script>';        // Prompts the user
          print '<script>window.location.assign("index.php?controller=pages&action=upload");</script>'; // redirects to login.php
        }
      }
    } else {
      $this->render('error');
    }
  }
  public function scan()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if(isset($_SESSION['user'])){
        if ($_SESSION['user'] == 'admin') {
          $search = ipModel::iplistadmin();
          $this->render('scan', array("ip" => $search));
        } else {
          $search = ipModel::iplistuser($_SESSION['user']);
          $this->render('scan', array("ip" => $search));
        }
      }
      else{
        print '<script>alert("Đừng có cố chấp!");</script>';        // Prompts the user
        print '<script>window.location.assign("index.php?controller=pages&action=home");</script>';
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($_POST['ip'] != 'all') {
        if ($_SESSION['user'] == 'admin') {
          $output = shell_exec('nmap ' . $_POST['ip']);
          $search = ipModel::iplistadmin();
          $this->render('scan', array("res" => "<div class='container' style='margin-top: 100px '><pre>$output</pre></div>", "ip" => $search));
        } else {
          $output = shell_exec('nmap ' . $_POST['ip']);
          $search = ipModel::iplistuser($_SESSION['user']);
          $this->render('scan', array("res" => "<div class='container' style='margin-top: 100px'><pre>$output</pre></div>", "ip" => $search));
        }
      } else {
        $res = "";
        if ($_SESSION['user'] == 'admin') {
          $search = ipModel::iplistadmin();
          foreach ($search as $item) {
            $output = shell_exec('nmap ' . $item);
            $res = $res."<div class='container' style='margin-top: 100px'><pre>$output</pre></div>";
          }
          $this->render('scan', array("res" => $res, "ip" => $search));
        } else {
          $search = ipModel::iplistuser($_SESSION['user']);
          foreach ($search as $item) {
            $output = shell_exec('nmap ' . $item);
            $res = $res."<div class='container' style='margin-top: 100px'><pre>$output</pre></div>";
          }
          $this->render('scan', array("res" => $res , "ip" => $search));
        }
      }
    }
  }
  public function error()
  {
    $this->render('errors');
  }
  public function logout()
  {
    $_SESSION['user'] = null;
    $this->render('home');
  }
  public function admin()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if ($_SESSION['user'] == 'admin')
        $this->render('admin');
      else {
        print '<script>alert("Đừng có cố chấp!");</script>';
        print '<script>window.location.assign("index.php?controller=pages&action=home");</script>';      // Prompts the user
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($_SESSION['user'] == 'admin') {
        if ($_POST['action'] == 'add') {
          if (strlen($_POST['username']) == 0 || UserModel::checkuser($_POST['username'])) {
            print '<script>alert("Username không hợp lệ hoặc đã tồn tại, vui lòng chọn lại");</script>';
            print '<script>window.location.assign("index.php?controller=pages&action=admin");</script>';
          } else {
            UserModel::insert($_POST['username'], $_POST['username']);
            print '<script>alert("Thành công");</script>';
            print '<script>window.location.assign("index.php?controller=pages&action=admin");</script>';
          }
        } else if ($_POST['action'] == 'delete') {
          if (!UserModel::checkuser($_POST['username']) || $_POST['username'] == 'admin') {
            print '<script>alert("Username không tồn tại hoặc không hợp lệ, vui lòng chọn lại");</script>';
            print '<script>window.location.assign("index.php?controller=pages&action=admin");</script>';
          } else {
            UserModel::del($_POST['username']);
            print '<script>alert("Thành công");</script>';
            print '<script>window.location.assign("index.php?controller=pages&action=admin");</script>';
          }
        } else if ($_POST['action'] == 'list') {
          $req = UserModel::list();
          $print = "";
          foreach ($req as $r) {
            $print = $print . "<div class='container' ><pre>$r[0]</pre></div>";
          }
          $this->render('admin', array("list" => $print));
        }
      } else {
        print '<script>alert("Đừng có cố chấp!");</script>';
        print '<script>window.location.assign("index.php?controller=pages&action=home");</script>';      // Prompts the user
      }
    }
  }
}
