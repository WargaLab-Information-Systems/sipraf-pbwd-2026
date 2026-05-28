<?php

// mengambil semua data approval beserta relasi reservation, facility, dan user
function getAllApproval($conn) {
    $query = "SELECT 
                a.id,
                a.status AS status_approval,
                a.notes AS catatan_approval,
                a.created_at AS tanggal_approval,
                r.id AS reservation_id,
                r.tanggal,
                r.jam_mulai,
                r.jam_selesai,
                r.notes AS catatan_reservasi,
                r.status AS status_reservasi,
                f.name AS nama_fasilitas,
                f.kategori,
                u_peminjam.name AS nama_peminjam,
                u_supervisor.name AS nama_supervisor
              FROM approvals a
              JOIN reservations r ON a.reservation_id = r.id
              JOIN facilities f ON r.facility_id = f.id
              JOIN users u_peminjam ON r.user_id = u_peminjam.id
              JOIN users u_supervisor ON a.user_id = u_supervisor.id
              ORDER BY a.created_at DESC";

    $result = mysqli_query($conn, $query);
    return $result;
}

// mengambil data approval berdasarkan user_id peminjam (untuk role borrower)
function getApprovalByUser($conn, $user_id) {
    $query = "SELECT 
                a.id,
                a.status AS status_approval,
                a.notes AS catatan_approval,
                a.created_at AS tanggal_approval,
                r.id AS reservation_id,
                r.tanggal,
                r.jam_mulai,
                r.jam_selesai,
                r.notes AS catatan_reservasi,
                r.status AS status_reservasi,
                f.name AS nama_fasilitas,
                f.kategori,
                u_peminjam.name AS nama_peminjam,
                u_supervisor.name AS nama_supervisor
              FROM approvals a
              JOIN reservations r ON a.reservation_id = r.id
              JOIN facilities f ON r.facility_id = f.id
              JOIN users u_peminjam ON r.user_id = u_peminjam.id
              JOIN users u_supervisor ON a.user_id = u_supervisor.id
              WHERE r.user_id = ?
              ORDER BY a.created_at DESC";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}

// mengambil detail satu data approval berdasarkan id approval
function getDetailApproval($conn, $id) {
    $query = "SELECT 
                a.id,
                a.status AS status_approval,
                a.notes AS catatan_approval,
                a.created_at AS tanggal_approval,
                r.id AS reservation_id,
                r.tanggal,
                r.jam_mulai,
                r.jam_selesai,
                r.notes AS catatan_reservasi,
                r.status AS status_reservasi,
                f.name AS nama_fasilitas,
                f.kategori,
                f.kapasitas,
                f.deskripsi AS deskripsi_fasilitas,
                u_peminjam.name AS nama_peminjam,
                u_peminjam.email AS email_peminjam,
                u_supervisor.name AS nama_supervisor,
                u_supervisor.email AS email_supervisor
              FROM approvals a
              JOIN reservations r ON a.reservation_id = r.id
              JOIN facilities f ON r.facility_id = f.id
              JOIN users u_peminjam ON r.user_id = u_peminjam.id
              JOIN users u_supervisor ON a.user_id = u_supervisor.id
              WHERE a.id = ?
              LIMIT 1";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// mengambil semua data approval untuk keperluan laporan
function getLaporanApproval($conn) {
    $query = "SELECT 
                a.id,
                a.status AS status_approval,
                a.notes AS catatan_approval,
                a.created_at AS tanggal_approval,
                r.tanggal,
                r.jam_mulai,
                r.jam_selesai,
                f.name AS nama_fasilitas,
                f.kategori,
                u_peminjam.name AS nama_peminjam,
                u_supervisor.name AS nama_supervisor
              FROM approvals a
              JOIN reservations r ON a.reservation_id = r.id
              JOIN facilities f ON r.facility_id = f.id
              JOIN users u_peminjam ON r.user_id = u_peminjam.id
              JOIN users u_supervisor ON a.user_id = u_supervisor.id
              ORDER BY a.created_at DESC";

    $result = mysqli_query($conn, $query);
    $data_laporan = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data_laporan[] = $row;
    }

    return $data_laporan;
}