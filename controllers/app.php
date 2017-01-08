<?php

class App
{
    public function handle()
    {
        include_once 'models/reservation.php';
        include_once 'models/passenger.php';
        if (isset($_POST['new'])) {
            $this->new();
        } elseif (isset($_POST['step_1'])) {
            $this->step_1();
        } elseif (isset($_POST['step_2'], $_SESSION['trip'])) {
            $this->step_2();
        } elseif (isset($_POST['destroy'])) {
            $this->cancel();
        } elseif (isset($_POST['remove'])) {
            $id = $_POST['remove'];
            Reservation::remove($id);
            $this->home();
        } elseif (isset($_POST['edit'])) {
            $id = $_POST['edit'];
            $this->load_reservation_to_session($id);
            $this->new();
        } else {
            $this->home();
        }
    }

    private function home()
    {
        include 'views/reservation-form-0.php';
    }

    private function new($errors = null)
    {
        if (isset($_SESSION['trip'])) {
            $trip = unserialize($_SESSION['trip']);
        } else {
            $trip = null;
        }

        include 'views/reservation-form-1.php';
    }

    private function load_reservation_to_session($id)
    {
        $trip = Reservation::get($id);
        $_SESSION['trip'] = serialize($trip);
    }

    private function step_1($errors=null)
    {
        // Check if data is already in the session
        if (isset($_SESSION['trip'])) {
            $trip = unserialize($_SESSION['trip']);
        } else {
            $trip = new Reservation();
        }

        // If the errors variable is non null it means
        // we came from this form but had an error,
        // the POST parameters will not be set but
        // the session will contain an object
        if (empty($errors)) {
            $form_errors = array();

            if (empty($_POST['destination'])) {
                $form_errors['dest_set'] = false;
            } else {
                $target = $_POST['destination'];
                $trip->set_destination($target);
            }

            if (empty($_POST['places'])) {
                $form_errors['places_set'] = false;
            } elseif ($_POST['places'] <= 0) {
                $form_errors['places_pos'] = false;
            } else {
                $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
                $trip->set_n_passengers($places);
            }

            $insurance = isset($_POST['insurance']) ? (bool) $_POST['insurance'] : false;
            $trip->set_cancellation_insurance($insurance);

            $_SESSION['trip'] = serialize($trip);

            // If the validation failed
            if (!empty($form_errors)) {
                $this->new($form_errors);
                return;
            }
        }

        include 'views/reservation-form-2.php';
    }

    private function step_2()
    {
        // At this point there must be a trip object in
        // session, if not it's a bug...
        $trip = unserialize($_SESSION['trip']);

        $travellers = $_POST['traveller'];
        $ages = $_POST['age'];

        // Avoid douple passengers caused by add_passenger
        $trip->erase_passengers_DB();
        unset($trip->passengers);

        $form_errors = array();

        foreach ($travellers as $i => $traveller) {
            if (empty($traveller)) {
                $form_errors["t".$i] = false;
            }

            if (empty($ages[$i])) {
                $form_errors["a".$i] = false;
            }

            $trip->add_passenger(new passenger($traveller, $ages[$i]));
            //$age = $ages[$i];
        }

        $_SESSION['trip'] = serialize($trip);

        // If the validation failed
        if (!empty($form_errors)) {
            $this->step_1($form_errors);
            return;
        }

        $id_travel = $trip->get_id_travel();
        $destination = $trip->show_dest();
        $insurance_Bool = $trip->has_insurance();
        $insurance_T = $trip->case_insurance();
        $passengers = $trip->get_passengers();
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
