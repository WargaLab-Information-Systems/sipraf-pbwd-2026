<?php

require_once './helper/db_conn.php';
require_once './helper/data/reservation.php';

$action_type = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');


if ($action_type === 'cancel') {
    $id_batal = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id_batal > 0) {
        cancelReservation($conn, $id_batal);
    }

    header("Location: ../pages/reservation/index.php");
    exit();
}

function prosesStatusReservasi($conn, $id, $status)
{
    $status_valid = ['diajukan', 'disetujui', 'ditolak', 'dibatalkan'];

    if (!in_array($status, $status_valid)) {
        return false;
    }

    $hasil = updateStatusReservasi($conn, $id, $status);
    return $hasil;
}
