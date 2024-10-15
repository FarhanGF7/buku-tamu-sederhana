<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "db_bukutamu";

    $koneksi = mysqli_connect($server, $user, $password, $database);

    // Check connection
    if (!$koneksi) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>