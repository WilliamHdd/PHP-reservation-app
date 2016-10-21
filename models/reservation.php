<?php

include_once 'passenger.php';

class Reservation
{
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    private $passengers = array();

    public function __construct($dest, $n_p, $c_i)
    {
        $this->$destination = $dest;
        $this->$n_passengers = $n_p;
        $this->$cancellation_insurance = $c_i;
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
