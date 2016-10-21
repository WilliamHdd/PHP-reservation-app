<?php
if (isset($_POST['Submit'])) {
    if (empty($_POST['destination'])) {
        //raise error
      ?>
      <script >
          alert('Veuillez indiquer une destination.');
      </script>

      <?php
      include 'index.php';
    } elseif (empty($_POST['places'])) {
        //raise error
      ?>
        <script >
          alert('Minimum un voyageur requis.');
        </script >

      <?php
      include 'index.php';
    } elseif ($_POST['places'] <= 0) {
        //raise error
      ?>
        <script>
          alert('Veuillez entrez un nombre positifs de voyageurs. ');
        </script>
      <?php
      include 'index.php';
    } else {
        $_session['destination'] = $_POST['destination'];
        $_session['places'] = filter_var($_POST['places'], FILTER_VALIDATE_INT);
        $_session['insurance'] = $_POST['insurance'];
        include 'views/reservation-form-2.php';
    }
} elseif (isset($_POST['destroy'])) {
    session_destroy();
    include 'index.php';
} elseif (isset($_POST['step_2'])) {
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    include 'views/reservation-form-validated.php';
} elseif (isset($_POST['destroy_2'])) {
    session_destroy();
    include 'index.php';
} else {
    include 'views/reservation-form-1.php';
}
