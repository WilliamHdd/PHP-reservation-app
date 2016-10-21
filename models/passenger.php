<?php

class Passenger
{
    private $lastname;
    private $firstname;
    private $age;

    public function __construct($lname, $fname, $age)
    {
        $this->$lastname = $lname;
        $this->$firstname = $fname;
        $this->$age = $age;
    }
}
