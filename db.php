<?php
    $connection = mysqli_connect('localhost', 'root', '', 'ecommerce');
    if(!$connection) {
        die("Maʼlumotlar bazasiga ulanish amalga oshmadi");
    }
    $q = "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'";
    $connection -> query($q);

?>
