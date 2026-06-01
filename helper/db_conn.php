<?php

$conn = new mysqli(
    'localhost',
    'root',
    '',
    'db_sipraf'
);

if ($conn->connect_error) {

    die("Koneksi gagal: " . $conn->connect_error);
}
