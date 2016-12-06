<?php

include_once 'passenger.php';

class Reservation
{
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    private $passengers = array();
    private $id_travel = 0;

    public function set_destination($dest)
    {
        $this->destination = $dest;
    }

    public function set_id_travel($id)
    {
        $this->id_travel = $id;
    }

    public function get_id_travel()
    {
        return $this->id_travel;
    }
    public function get_destination()
    {
        return $this->destination;
    }

    public function set_n_passengers($n)
    {
        $this->n_passengers = $n;
    }

    public function set_cancellation_insurance($insurance)
    {
        $this->cancellation_insurance = $insurance;
    }

    public function has_insurance()
    {
        return $this->cancellation_insurance;
    }

    public function add_passenger($passenger)
    {
        $this->passengers[] = $passenger;
    }

    public function complete()
    {
        return false;
    }
    public function get_passengers()
    {
        return $this->passengers;
    }
    public function show_dest()
    {
        return $this->destination;
    }
    public function case_insurance()
    {
        if ($this->cancellation_insurance == true) {
            return 'avec';
        } else {
            return 'sans';
        }
    }
}
