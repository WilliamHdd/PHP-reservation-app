<?php

include_once 'passenger.php';

class Reservation
{
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    private $passengers = array();
    private $id_travel = 0;
    private $mysqli;

    public function set_destination($dest)
    {
        $this->destination = $dest;
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
        if (is_bool($insurance)) {
            $this->cancellation_insurance = $insurance;
        } else {
            throw new Exception('Expected a boolean!');
        }
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
    public function get_id_travel()
    {
        return $this->id_travel;
    }
    public function save()
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }

        $sqlReserv = "INSERT INTO avengers.avengers(endroit, Cancel_Insurance)
        VALUES('$this->destination','$this->cancellation_insurance')";
        if ($this->mysqli->query($sqlReserv) == true) {
            //  echo 'Record updated successfully';
            $id_insert = $this->mysqli->insert_id;
            $this->id_travel = $id_insert;
        } else {
            echo 'Error inserting record: '.$this->mysqli->error;
        }
        foreach ($this->passengers as $i => $passenger) {
            $sqlPerson = "INSERT INTO avengers.peoples(name, age, voyage)
            VALUES('$passenger->name','$passenger->age','$id_insert')";
            if ($this->mysqli->query($sqlPerson) == true) {
                //echo 'Record updated successfully';
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
        }
    }
}
