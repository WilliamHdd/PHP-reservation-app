<?php
if (isset($_POST['Submit']))
  {
    if(empty($_POST['destination']))
    {
      //raise error
      ?>
      <SCRIPT LANGUAGE = "JavaScript">
        {
          alert('Veuillez indiquer une destination.')
        }
      </SCRIPT>


      <?php
      include("index.php");
    }
    elseif (empty($_POST['places']))
    {
      //raise error
      ?>
      <SCRIPT LANGUAGE = "JavaScript">
        {
          alert('Minimum un voyageur requis.')
        }
      </SCRIPT>

      <?php
      include("index.php");
    }

    elseif ($_POST['places'] <= 0)
    {
      //raise error
      ?>
      <SCRIPT LANGUAGE = "JavaScript">
        {
          alert('Veuillez entrez un nombre positifs de voyageurs. ')
        }
      </SCRIPT>
      <?php
      include("index.php");
    }
    else
    {
      $_session['destination'] = $_POST['destination'];
      $_session['places'] = filter_var($_POST['places'], FILTER_VALIDATE_INT);
      $_session['insurance'] = $_POST['insurance'];
      include("vue.php");
    }

  }
  elseif (isset($_POST['destroy']))
  {
    session_destroy();
    include("index.php");
  }
?>
