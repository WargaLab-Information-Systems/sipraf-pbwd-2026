<?php
// Pastikan tidak ada spasi atau enter di atas tag <?php ini
require_once __DIR__ . '/../helper/db_conn.php';
require_once __DIR__ . '/../helper/data/facility.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $data = [
        'name' => $_POST['name'],
        'kategori' => $_POST['kategori'],
        'kapasitas' => $_POST['kapasitas'],
        'deskripsi' => $_POST['deskripsi'],
        'status' => $_POST['status']
    ];

    $redirect_url = '../pages/facilities/index.php';

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
    $redirect_url = '/sipraf-pbwd-2026/pages/facilities/index.php';
    deleteFacility($conn, $_GET['id']);
    header("Location: $redirect_url?status=deleted");
    exit;
}
