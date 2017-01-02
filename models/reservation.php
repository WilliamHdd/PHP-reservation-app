<?php

include_once 'passenger.php';

class Reservation
{
    private $id;
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    public $passengers = array();
    //private $id_travel = 0;
    private $mysqli;

    public function __construct(string $dest = null, bool $insurance = null, int $id = null)
    {
        if ($id != null) {
            $this->id = $id;
        }

        $this->destination = $dest;
        $this->cancellation_insurance = $insurance;
    }

    public function set_destination(string $dest)
    {
        $this->destination = $dest;
    }
    public function set_id_travel($value)
    {
        $this->id = $value;
    }

    public function get_destination()
    {
        return $this->destination;
    }

    public function set_n_passengers(int $n)
    {
        if (is_null($n)) {
            throw new Exception('Number of passengers is null');
        }
        $this->n_passengers = $n;
    }

    public function get_n_passengers()
    {
        return $this->n_passengers;
    }

    public function set_cancellation_insurance(bool $insurance)
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

    public function add_passenger(Passenger $passenger)
    {
        $this->passengers[] = $passenger;
        if (count($this->passengers) > $this->n_passengers) {
            $this->n_passengers = count($this->passengers);
        }
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
    public function insurance_to_string($case)
    {
        if ($case == 1) {
            return 'avec';
        } else {
            return 'sans';
        }
    }
    public function get_id_travel()
    {
        return $this->id;
    }

    public function load_data($id)
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }
        $load_Reserv = "SELECT * FROM avengers.avengers WHERE id ='$id'";

        $resultR = $this->mysqli->query($load_Reserv);

        $array = $resultR->fetch_array(MYSQLI_ASSOC);

        return $array;
    }

    public function load_people($id)
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }

        // FIXME: NOT GOOD --> SQL INJECTION RISK...
        $load_People = "SELECT * FROM avengers.peoples WHERE voyage =$id";
        $resultP = $this->mysqli->query($load_People);
        $posts = array();

        while ($row = $resultP->fetch_array()) {
            $ID = $row['id'];
            $name = $row['name'];
            $age = $row['age'];
            $voyage = $row['voyage'];

            $posts [] = array(
               'ID' => $ID,
               'name' => $name,
               'age' => $age,
               'voyage' => $voyage,
              );
        }

        return $posts;
    }

    public function save()
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }

        if ($this->id == null) {
            $sqlReserv = "INSERT INTO avengers.avengers(endroit, Cancel_Insurance)
        VALUES('$this->destination','$this->cancellation_insurance')";
            if ($this->mysqli->query($sqlReserv) == true) {
                //  echo 'Record updated successfully';
            $id_insert = $this->mysqli->insert_id;
                $this->id = $id_insert;
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
        } else {

            //UPDATE `peoples` SET `name` = 'Mathieux', `age` = '23' WHERE `peoples`.`id` = 86;
            $query = $this->mysqli->prepare('UPDATE avengers SET endroit = ?, Cancel_Insurance = ? WHERE avengers.id = ?');
            $query->bind_param('sii', $this->destination, $this->cancellation_insurance, $this->id);

            if ($query->execute() == false) {
                echo 'Error inserting record: '.$this->mysqli->error;
            }

            $query->close();
        }

        foreach ($this->passengers as $i => $passenger) {
            //var_dump($passenger->return_id());
            if ($passenger->id == null) {
                var_dump($this->passengers);
                echo '<br>';
                $sqlPerson = "INSERT INTO avengers.peoples(name, age, voyage)
                VALUES('$passenger->name','$passenger->age','$this->id')";
                if ($this->mysqli->query($sqlPerson) == true) {
                    //echo 'Record updated successfully';
                } else {
                    echo 'Error inserting record: '.$this->mysqli->error;
                }
            } else {
                echo 'Updating'.$passenger->return_id();
                $p_id = $passenger->return_id();
                var_dump($p_id);
                //UPDATE `peoples` SET `name` = 'Mathieux', `age` = '23' WHERE `peoples`.`id` = 86;
                $query = $this->mysqli->prepare('UPDATE peoples SET name = ?, age = ? WHERE voyage = ?');
                $query->bind_param('sii', $passenger->name, $passenger->age, $this->id);

                if ($query->execute() == false) {
                    echo 'Error inserting record: '.$this->mysqli->error;
                }

                $query->close();
            }
        }
    }

    public static function list_reservations()
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('SELECT * FROM avengers');
        $query->execute();
        $query->bind_result($id, $destination, $insurance);

        $reservations = array();

        while ($query->fetch()) {
            $reservations[] = ['id' => $id, 'destination' => $destination, 'insurance' => $insurance];
        }

        $query->close();

        return $reservations;
    }

    public static function remove($id)
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('DELETE FROM avengers WHERE id = ?');
        $query->bind_param('i', $id);
        $query->execute();
        $query->close();
    }
    public function erase_passengers_DB()
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');
        foreach ($this->passengers as $i => $passenger) {
            $query = $mysqli->prepare('DELETE FROM avengers.peoples where voyage = ?');
            $query->bind_param('i', $this->id);
            $query->execute();
            $query->close();
        }
    }
    public static function get($trip_id)
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('SELECT * FROM avengers WHERE id = ?');
        $query->bind_param('i', $trip_id);
        $query->execute();
        $query->bind_result($id, $destination, $insurance);
        $query->fetch();
        $query->close();

        $reservation = new self($destination, $insurance, $id);

        $query = $mysqli->prepare('SELECT * FROM peoples WHERE voyage = ?');
        $query->bind_param('i', $trip_id);
        $query->execute();
        $query->bind_result($id, $name, $age, $reserv_id);

        while ($query->fetch()) {
            $passenger = new Passenger($name, $age, $id);
            $reservation->add_passenger($passenger);
        }

        $query->close();

        return $reservation;
    }
}
