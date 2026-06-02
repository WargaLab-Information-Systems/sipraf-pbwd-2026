<?php

require_once __DIR__ . '/../helper/data/approval.php';
// mengolah data laporan approval 
function generateLaporan($conn) {
    $data_laporan = getLaporanApproval($conn);

    $total = count($data_laporan);
    $total_disetujui = 0;
    $total_ditolak = 0;

    foreach ($data_laporan as $row) {
        if ($row['status_approval'] === 'disetujui') {
            $total_disetujui++;
        } else if ($row['status_approval'] === 'ditolak') {
            $total_ditolak++;
        }
    }

    $hasil_laporan = [
        'total'           => $total,
        'total_disetujui' => $total_disetujui,
        'total_ditolak'   => $total_ditolak,
        'detail'          => $data_laporan
    ];

    return $hasil_laporan;
}

// handle request edit approval (POST dari form modal di detail.php)
function handleEditApproval($conn) {
    session_start();

    // hanya admin dan supervisor yang boleh edit
    $role    = $_SESSION['role']    ?? '';
    $user_id = $_SESSION['user_id'] ?? 0;

    if (!in_array($role, ['admin', 'supervisor'])) {
        http_response_code(403);
        header('Location: ../pages/approval/index.php');
        exit;
    }

    $id     = isset($_POST['id'])     ? (int) $_POST['id']         : 0;
    $status = isset($_POST['status']) ? trim($_POST['status'])      : '';
    $notes  = isset($_POST['notes'])  ? trim($_POST['notes'])       : '';

    if ($id <= 0 || !in_array($status, ['disetujui', 'ditolak'])) {
        $_SESSION['flash_error'] = 'Data tidak valid.';
        header("Location: ../pages/approval/detail.php?id=$id");
        exit;
    }

    require_once __DIR__ . '/../helper/db_conn.php';

    // supervisor hanya boleh edit approval miliknya sendiri
    if ($role === 'supervisor') {
        $cek = mysqli_prepare($conn, "SELECT id FROM approvals WHERE id = ? AND user_id = ?");
        mysqli_stmt_bind_param($cek, 'ii', $id, $user_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);
        if (mysqli_stmt_num_rows($cek) === 0) {
            $_SESSION['flash_error'] = 'Anda tidak memiliki akses untuk mengedit approval ini.';
            header("Location: ../pages/approval/detail.php?id=$id");
            exit;
        }
    }

    if (updateApproval($conn, $id, $status, $notes)) {
        $_SESSION['flash_success'] = 'Keputusan approval berhasil diperbarui.';
    } else {
        $_SESSION['flash_error'] = 'Gagal memperbarui data.';
    }

    header("Location: ../pages/approval/detail.php?id=$id");
    exit;
}

// jalankan jika dipanggil langsung via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'edit_approval') {
    require_once __DIR__ . '/../helper/db_conn.php';
    handleEditApproval($conn);
}
