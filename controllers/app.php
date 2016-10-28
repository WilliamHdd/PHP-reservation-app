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
            include 'models/reservation.php';

            $target = $_POST['destination'];
            $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
            $insurance = $_POST['insurance'];

            $trip = new Reservation();
            $trip->set_destination($target);
            $trip->set_n_passengers($places);
            $trip->set_cancellation_insurance($insurance);

            $_SESSION['trip'] = serialize($trip);

            include 'views/reservation-form-2.php';
        }
    }

    private function step_2()
    {
        $travellor = $_POST['travellor'];
        $age = $_POST['age'];

        include 'models/passenger.php';
        include 'models/reservation.php';

        $person = new passenger($travellor, $age);

        $trip = unserialize($_SESSION['trip']);
        $trip->add_passenger($person);
        $passengers = $trip->get_passengers();
        $_SESSION['trip'] = serialize($trip);
        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        include 'index.php';
    }
}
