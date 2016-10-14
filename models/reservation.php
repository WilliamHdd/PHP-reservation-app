<?php
class Reservation {
   private $destination;
   private $n_passengers = 0;
   private $cancellation_insurance = false;
   private $passengers = array();

   public function __construct($dest, $n_p, $c_a) {
       $this->$destination = $dest;
       $this->$n_passengers = $n_p;
       $this->$cancellation_insurance = $c_a;
   }

   public function add_passenger($passenger) {
       $this->$passenger[] = $passenger;
   }
}

class Passenger {
    private $lastname;
    private $firstname;
    private $age;

    public function __construct($lname, $fname, $age) {
        $this->$lastname = $lname;
        $this->$firstname = $fname;
        $this->$age = $age;
    }
}
?>
