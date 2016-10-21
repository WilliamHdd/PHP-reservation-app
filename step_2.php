<?php

if (isset($_POST['step_2'])) {
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    include 'views/reservation-form-validated.php';
} elseif (isset($_POST['destroy_2'])) {
    session_destroy();
    include 'index.php';
}
