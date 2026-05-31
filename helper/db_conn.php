<?php

$host = "localhost";
$user = "root";
$pw   = "";
$db   = "db_sipraf";

$conn = new mysqli(
    $host,
    $user,
    $pw,
    $db
);

if ($conn->connect_error) {

    die("Koneksi gagal: " . $conn->connect_error);

}

?>
