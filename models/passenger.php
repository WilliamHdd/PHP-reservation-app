<?php

class Passenger
{
    public $name;
    public $age;
    public $id = null;

    public function __construct($name, $age, $id = null)
    {
        $this->name = $name;
        $this->age = $age;
        if ($id != null) {
            $this->id = $id;
        }
    }

    public function return_id()
    {
        return $this->id;
    }
}
