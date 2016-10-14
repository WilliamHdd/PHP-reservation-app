<?php
if (isset($_POST['Submit']))
  {
    $_session['Dest'] = $_POST['Dest'];
    include("vue.php");
  }
  elseif (isset($_POST['destroy']))
  {
    session_destroy();
    include("index.php");
  }
?>
