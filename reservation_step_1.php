<?php
if (isset($_POST['Submit']))
  {
    if(empty($_POST['destination']))
    {
      //raise error
      echo "problem destination empty";
    }
    elseif (empty($_POST['places']))
    {
      //raise error
      echo 'problem places empty';
    }

    elseif ($_POST['places'] <= 0)
    {
      //raise error
      echo"error negative place";
    }
    else
    {
      $_session['destination'] = $_POST['destination'];
      $_session['places'] = filter_var($_POST['places'], FILTER_VALIDATE_INT);
      $_session['insurance'] = $_POST['insurance'];
      include("reservation-form-2.php");
    }

  }
  elseif (isset($_POST['destroy']))
  {
    session_destroy();
    include("index.php");
  }
?>
