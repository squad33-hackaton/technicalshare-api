<?php

    require_once(__DIR__ . "/../include/bootstrap.php");
    header("Content-type: application/json");

    new App\Core\Router();
    
?>
