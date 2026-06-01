<?php

$conn = new mysqli(
    'localhost',
    'demo',
    'pw1234',
    'db_sipraf'
);

if ($conn->connect_error) {

    die("Koneksi gagal: " . $conn->connect_error);
}
