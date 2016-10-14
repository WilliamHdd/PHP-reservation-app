<?php
if (isset($_POST['Submit']))
  {
    $_session['destination'] = $_POST['destination'];
    $_session['places'] = filter_var($_POST['places'], FILTER_VALIDATE_INT);
    $_session['assurance'] = $_POST['assurance'];
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    include("vue.php");
  }
  elseif (isset($_POST['destroy']))
  {
    session_destroy();
    include("index.php");
  }
?>
