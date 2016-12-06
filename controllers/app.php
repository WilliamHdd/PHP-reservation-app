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

            $_SESSION['trip'] = serialize($trip);
            $id_voyage = $this->mysqli->query('SELECT LAST_INSERT_ID() INTO @avengers.avengers') + 1;
            echo $id_voyage;

            $sql = "INSERT INTO avengers.avengers (id, endroit, people, Cancel_Insurance)
           VALUES ('$id_voyage', '$target', '', '$euromut')";
            if ($this->mysqli->query($sql) == true) {
                echo 'Record updated successfully';
                $id_insert = $this->mysqli->insert_id;
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }

            include 'views/reservation-form-2.php';
        }
    }

    private function step_2()
    {
        $travellers = $_POST['traveller'];
        $ages = $_POST['age'];

        $trip = unserialize($_SESSION['trip']);

        foreach ($travellers as $i => $traveller) {
            $trip->add_passenger(new passenger($traveller, $ages[$i]));
            $age = $ages[$i];
            $place = $trip->show_dest();
            $id_voyeger = $this->mysqli->query('SELECT LAST_INSERT_ID() INTO @avengers.peoples') + 1;
            $voyager = "INSERT INTO avengers.peoples(id, name, age, voyages)
            VALUES('$i', '$traveller', '$age', '$place')";
            if ($this->mysqli->query($voyager) == true) {
                echo 'Record updated successfully';
                $id_insert = $this->mysqli->insert_id;
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
        }
        $destination = $trip->show_dest();
        $insurance = $trip->case_insurance();
        $passengers = $trip->get_passengers();
        $_SESSION['trip'] = serialize($trip);
        $query = 'SELECT * FROM users';
        $result = $this->mysqli->query($query) or die('Query failed ');
        if ($result->num_rows == 0) {
            echo 'Aucune ligne trouvée, rien à afficher.';
            exit;
        }

        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        include 'index.php';
    }
}
