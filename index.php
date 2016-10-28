<?php
    session_start();
    include 'controllers/app.php';
    $app = new App();
    $app->handle();
