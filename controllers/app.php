<?php

class App
{
    public function handle()
    {
        include_once 'models/reservation.php';
        include_once 'models/passenger.php';
        if (isset($_POST['new'])) {
            $this->new();
        } elseif (isset($_POST['old'])) {
            $this->old();
        } elseif (isset($_POST['step_1'])) {
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
        include 'views/reservation-form-0.php';
    }
    private function new()
    {
        include 'views/reservation-form-1.php';
    }
    private function old()
    {
        $trip = new Reservation();
        //$trip->acces_DB();
        $reserv_ID = filter_var($_POST['reserv_ID'], FILTER_VALIDATE_INT);

        $data = $trip->load_data($reserv_ID);
        //var_dump($data);
        $destination = $data['endroit'];
        $assurance = $data['Cancel_Insurance'];

        include 'views/reservation-back.php';
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
          $this->new();
        } elseif (empty($_POST['places'])) {
            //raise error
          ?>
            <script >
              alert('Minimum un voyageur requis.');
            </script >

          <?php
          $this->new();
        } elseif ($_POST['places'] <= 0) {
            //raise error
          ?>
            <script>
              alert('Veuillez entrez un nombre positifs de voyageurs. ');
            </script>
          <?php
          $this->new();
        } else {
            $trip = new Reservation();

            $target = $_POST['destination'];
            $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
            $insurance = isset($_POST['insurance']) ? (bool) $_POST['insurance'] : false;

            $trip->set_destination($target);
            $trip->set_n_passengers($places);
            $trip->set_cancellation_insurance($insurance);
            $euromut = $trip->case_insurance();

            $_SESSION['trip'] = serialize($trip);

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
        }
        $id_travel = $trip->get_id_travel();
        $destination = $trip->show_dest();
        $insurance_Bool = $trip->has_insurance();
        $insurance_T = $trip->case_insurance();
        $passengers = $trip->get_passengers();
        $_SESSION['trip'] = serialize($trip);
        //save() sets all the detail of the reservation into our database 'avengers'
        $trip->save();
        /* As the id of the reservation is set in to save() routine, get_id_travel() needs
        to be called after save(). */
        $id_travel = $trip->get_id_travel();

        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        $this->home();
    }
}
