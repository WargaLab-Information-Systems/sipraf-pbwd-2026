<?php

function insertReservation($conn, $data) {

    $user_id = $data['user_id'];
    $facility_id = $data['facility_id'];
    $tanggal = $data['tanggal'];
    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];
    $notes = $data['notes'];

    $query = "INSERT INTO reservations
    (
        user_id,
        facility_id,
        tanggal,
        jam_mulai,
        jam_selesai,
        notes,
        status
    )

    VALUES
    (
        '$user_id',
        '$facility_id',
        '$tanggal',
        '$jam_mulai',
        '$jam_selesai',
        '$notes',
        'diajukan'
    )";

    return mysqli_query($conn, $query);

}

function getReservations($conn) {

    $query = mysqli_query($conn, "

    SELECT
        reservations.*,
        users.name AS user_name,
        facilities.name AS facility_name

    FROM reservations

    JOIN users
    ON reservations.user_id = users.id

    JOIN facilities
    ON reservations.facility_id = facilities.id

    ORDER BY reservations.id DESC

    ");

    return $query;

}

?>