<?php
require_once __DIR__ . '/../helper/db_conn.php';

function insertReservation($conn, $user_id, $facility_id, $tanggal, $jam_mulai, $jam_selesai, $notes) {
    // Prepare statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, facility_id, tanggal, jam_mulai, jam_selesai, notes, status) VALUES (?, ?, ?, ?, ?, ?, 'diajukan')");

    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iissss", $user_id, $facility_id, $tanggal, $jam_mulai, $jam_selesai, $notes);

    if($stmt->execute()){
        $stmt->close();
        return true;
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

// Tangkap data dari form
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_POST['user_id'];
    $facility_id = $_POST['facility_id'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $notes = $_POST['notes'];

    if(insertReservation($conn, $user_id, $facility_id, $tanggal, $jam_mulai, $jam_selesai, $notes)){
        // Redirect ke index atau halaman sukses
        header("Location: ../pages/reservation/index.php?success=1");
        exit;
    } else {
        echo "Gagal menambahkan data!";
    }
}