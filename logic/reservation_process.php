<?php

require '../helper/db_conn.php';
require '../helper/data/reservation.php';

$result = insertReservation($conn, $_POST);

if($result) {

    header("Location: ../pages/reservation/detail.php");

} else {

    echo "Gagal menyimpan data";

}

?>


