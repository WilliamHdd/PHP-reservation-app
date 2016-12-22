<?php

class Passenger
{
    public $name;
    public $age;
    private $id = null;

    public function __construct($name, $age, $id = null)
    {
        $this->name = $name;
        $this->age = $age;

        if ($id != null) {
            $this->id = $id;
        }
    }
}
