<?php

require_once __DIR__ . '/../helper/data/reservation.php';

// proses perubahan status reservasi berdasar keputusan approval
function prosesStatusReservasi($conn, $id, $status) {
    // daftar status yang valid 
    $status_valid = ['diajukan', 'disetujui', 'ditolak', 'dibatalkan'];

    // validasi status yang dikirim harus sesuai 
    if (!in_array($status, $status_valid)) {
        return false;
    }

    // memanggil helper untuk update status di  reservations
    $hasil = updateStatusReservasi($conn, $id, $status);
    return $hasil;
}