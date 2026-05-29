<?php


// Memanggil koneksi database
require_once __DIR__ . '/../db_conn.php';

/**
 * Mengambil semua data reservasi untuk keperluan cetak laporan.
 * * @param mysqli $conn Objek koneksi database.
 * @return array Kumpulan data laporan reservasi.
 */
function getAllReservations($conn) {
    $sql_query = "SELECT r.*, u.name AS borrower_name, f.name AS facility_name, f.kategori 
                  FROM reservations r
                  JOIN users u ON r.user_id = u.id
                  JOIN facilities f ON r.facility_id = f.id
                  ORDER BY r.created_at DESC";
                  
    $result_data = mysqli_query($conn, $sql_query);
    $list_reservations = [];
    
    if ($result_data) {
        while ($row_data = mysqli_fetch_assoc($result_data)) {
            $list_reservations[] = $row_data;
        }
    }
    
    return $list_reservations;
}

/**
 * Mengambil satu data detail reservasi berdasarkan ID.
 * * @param mysqli $conn Objek koneksi database.
 * @param int $id_reservation ID dari reservasi yang dicari.
 * @return array|null Data detail reservasi atau null jika tidak ditemukan.
 */
function getReservationById($conn, $id_reservation) {
    $id_reservation = (int)$id_reservation;
    $sql_query = "SELECT r.*, u.name AS borrower_name, u.email AS borrower_email,
                         f.name AS facility_name, f.kategori, f.deskripsi AS facility_desc,
                         a.status AS approval_status, a.notes AS approval_notes, a.created_at AS approved_at,
                         su.name AS supervisor_name
                  FROM reservations r
                  JOIN users u ON r.user_id = u.id
                  JOIN facilities f ON r.facility_id = f.id
                  LEFT JOIN approvals a ON r.id = a.reservation_id
                  LEFT JOIN users su ON a.user_id = su.id
                  WHERE r.id = $id_reservation";
                  
    $result_data = mysqli_query($conn, $sql_query);
    
    if ($result_data && mysqli_num_rows($result_data) > 0) {
        return mysqli_fetch_assoc($result_data);
    }
    
    return null;
}

/**
 * Mengubah status reservasi menjadi 'dibatalkan'.
 * * @param mysqli $conn Objek koneksi database.
 * @param int $id_reservation ID dari reservasi yang ingin dibatalkan.
 * @return bool True jika berhasil, false jika gagal.
 */
function cancelReservation($conn, $id_reservation) {
    $id_reservation = (int)$id_reservation;
    $sql_query = "UPDATE reservations SET status = 'dibatalkan' WHERE id = $id_reservation";
    
    return mysqli_query($conn, $sql_query);
}

/**
 * Menghapus data reservasi dari database.
 * * @param mysqli $conn Objek koneksi database.
 * @param int $id_reservation ID dari reservasi yang ingin dihapus.
 * @return bool True jika berhasil, false jika gagal.
 */
function deleteReservation($conn, $id_reservation) {
    $id_reservation = (int)$id_reservation;
    $sql_query = "DELETE FROM reservations WHERE id = $id_reservation";
    
    return mysqli_query($conn, $sql_query);
}

/**
 * Memperbarui data pengajuan/reservasi.
 * * @param mysqli $conn Objek koneksi database.
 * @param int $id_reservation ID dari reservasi yang ingin diubah.
 * @param string $tanggal_baru Tanggal peminjaman baru (YYYY-MM-DD).
 * @param string $jam_mulai_baru Jam mulai baru (HH:MM:SS).
 * @param string $jam_selesai_baru Jam selesai baru (HH:MM:SS).
 * @param string $catatan_baru Catatan atau keterangan baru.
 * @return bool True jika berhasil, false jika gagal.
 */
function updateReservation($conn, $id_reservation, $tanggal_baru, $jam_mulai_baru, $jam_selesai_baru, $catatan_baru) {
    $id_reservation = (int)$id_reservation;
    $tanggal_baru = mysqli_real_escape_string($conn, $tanggal_baru);
    $jam_mulai_baru = mysqli_real_escape_string($conn, $jam_mulai_baru);
    $jam_selesai_baru = mysqli_real_escape_string($conn, $jam_selesai_baru);
    $catatan_baru = mysqli_real_escape_string($conn, $catatan_baru);
    
    $sql_query = "UPDATE reservations 
                  SET tanggal = '$tanggal_baru', 
                      jam_mulai = '$jam_mulai_baru', 
                      jam_selesai = '$jam_selesai_baru', 
                      notes = '$catatan_baru' 
                  WHERE id = $id_reservation";
                  
    return mysqli_query($conn, $sql_query);

// mengubah status reservasi setelah keputusan approval dibuat
function updateStatusReservasi($conn, $id, $status) {
    $query = "UPDATE reservations SET status = ? WHERE id = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    return mysqli_stmt_execute($stmt);
}