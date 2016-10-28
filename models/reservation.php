<?php

include_once 'passenger.php';

class Reservation
{
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    private $passengers = array();

    public function set_destination($dest)
    {
        $this->destination = $dest;
    }

    public function set_n_passengers($n)
    {
        $this->n_passengers = $n;
    }

    public function set_cancellation_insurance($insurance)
    {
        $this->cancellation_insurance = $insurance;
    }

    public function add_passenger($passenger)
    {
        $this->$passenger[] = $passenger;
    }

    public function complete()
    {
        return false;
    }
}
