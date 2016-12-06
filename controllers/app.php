<?php

class App
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }
    }

    public function handle()
    {
        include_once 'models/reservation.php';
        include_once 'models/passenger.php';

        if (isset($_POST['step_1'])) {
            $this->step_1();
        } elseif (isset($_POST['step_2'], $_SESSION['trip'])) {
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
            $trip = new Reservation();

            $target = $_POST['destination'];
            $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
            $insurance = isset($_POST['insurance']) ? $_POST['insurance'] : false;

            $trip->set_destination($target);
            $trip->set_n_passengers($places);
            $trip->set_cancellation_insurance($insurance);
            $euromut = $trip->case_insurance();

            $sql = "INSERT INTO avengers.avengers (endroit, Cancel_Insurance)
           VALUES ('$target', '$euromut')";
            if ($this->mysqli->query($sql) == true) {
                //  echo 'Record updated successfully';
                $id_insert = $this->mysqli->insert_id;
                $trip->set_id_travel($id_insert);
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
            $_SESSION['trip'] = serialize($trip);

            include 'views/reservation-form-2.php';
        }
    }

    private function step_2()
    {
        $travellers = $_POST['traveller'];
        $ages = $_POST['age'];
        $trip = unserialize($_SESSION['trip']);
        $id_travel = $trip->get_id_travel();

        foreach ($travellers as $i => $traveller) {
            $trip->add_passenger(new passenger($traveller, $ages[$i]));

            $age = $ages[$i];
            $id_travel = $trip->get_id_travel();
            $voyager = "INSERT INTO avengers.peoples( name, age, voyage)
            VALUES( '$traveller', '$age', '$id_travel')";

            if ($this->mysqli->query($voyager) == true) {
                //echo 'Record updated successfully';
                $id_insert = $this->mysqli->insert_id;
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
        }
        $destination = $trip->show_dest();
        $insurance = $trip->case_insurance();
        $passengers = $trip->get_passengers();
        $id_dest = $trip->get_id_travel();
        $_SESSION['trip'] = serialize($trip);

        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        include 'index.php';
    }
}
