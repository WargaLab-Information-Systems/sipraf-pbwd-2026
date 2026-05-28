<?php


// 1. Panggil file helper data agar fungsi 'cancelReservation' dan koneksi '$conn' bisa dibaca
require_once __DIR__ . '/../helper/data/reservation.php';

// 2. Tangkap parameter aksi dari URL (GET) atau dari Form (POST)
$action_type = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');


if ($action_type === 'cancel') {
    // Memastikan ID yang diambil dari URL adalah angka bulat (?id=...)
    $id_batal = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($id_batal > 0) {
        // Jalankan fungsi update status di database helper
        cancelReservation($conn, $id_batal);
    }
    
    // Setelah selesai membatalkan, langsung usir user kembali ke halaman utama
    header("Location: ../pages/reservation/index.php");
    exit();
}

