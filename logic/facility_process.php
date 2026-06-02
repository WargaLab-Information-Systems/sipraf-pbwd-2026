<?php
require_once __DIR__ . '/../helper/db_conn.php';
require_once __DIR__ . '/../helper/data/facility.php';

$redirect_url = '../pages/facilities/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $data = [
        'name'      => $_POST['name'] ?? '',
        'kategori'  => $_POST['kategori'] ?? '',
        'kapasitas' => $_POST['kapasitas'] ?? '',
        'deskripsi' => $_POST['deskripsi'] ?? '',
        'status'    => $_POST['status'] ?? 'tersedia'
    ];

    if ($action === 'insert') {
        insertFacility($conn, $data);
        header("Location: $redirect_url?status=success");
        exit;
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        updateFacility($conn, $id, $data);
        header("Location: $redirect_url?status=success");
        exit;
    }

    header("Location: $redirect_url");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isFacilityInUse($conn, $id)) {
            // Jika ya, batalkan hapus dan kirim status error_used
            header("Location: $redirect_url?status=error_used");
            exit;
        } else {
            deleteFacility($conn, $id);
            header("Location: $redirect_url?status=deleted");
            exit;
        }
    }
    
    header("Location: $redirect_url");
    exit;
}