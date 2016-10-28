<?php

class App
{
    public function __construct()
    {
        // code...
    }

    public function handle()
    {
        if (isset($_POST['step_1'])) {
            $this->step_1();
        } elseif (isset($_POST['step_2'])) {
            $this->step_2();
        } elseif (isset($_POST['destroy']) || isset($_POST['destroy_2'])) {
            $this->cancel();
        } else {
            $this->home();
        }
    }

    private function home()
    {
        include 'views/reservation-form-1.php';
    }

    private function step_1()
    {
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
    }

    private function step_2()
    {
        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        include 'index.php';
    }
}
