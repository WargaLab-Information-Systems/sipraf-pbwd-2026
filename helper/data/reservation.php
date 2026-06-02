<?php

require_once __DIR__ . '/../db_conn.php';

/* =========================
   INSERT RESERVATION
========================= */
 main
function insertReservation($conn, $data)
{
    $user_id = $data['user_id'];
    $facility_id = $data['facility_id'];
    $tanggal = $data['tanggal'];
    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];
    $notes = $data['notes'];

    $query = "INSERT INTO reservations (
                user_id,
                facility_id,
                tanggal,
                jam_mulai,
                jam_selesai,
                notes,
                status
            )
            VALUES (
                '$user_id',
                '$facility_id',
                '$tanggal',
                '$jam_mulai',
                '$jam_selesai',
                '$notes',
                'diajukan'
            )";

    return mysqli_query($conn, $query);
}

/* =========================
   GET ALL RESERVATIONS
========================= */
function getReservations($conn)
{
    $query = mysqli_query($conn, "
        SELECT
            reservations.*,
            users.name AS user_name,
            facilities.name AS facility_name
        FROM reservations
        JOIN users
            ON reservations.user_id = users.id
        JOIN facilities
            ON reservations.facility_id = facilities.id
        ORDER BY reservations.id DESC
    ");

    return $query;
}

/* =========================
   GET ALL RESERVATIONS ARRAY
========================= */
function getAllReservations($conn)
{
    $sql_query = "
        SELECT
            r.*,
            u.name AS borrower_name,
            f.name AS facility_name,
            f.kategori
        FROM reservations r
        JOIN users u
            ON r.user_id = u.id
        JOIN facilities f
            ON r.facility_id = f.id
        ORDER BY r.created_at DESC
    ";

    $result_data = mysqli_query($conn, $sql_query);

    $list_reservations = [];

    if ($result_data) {
        while ($row_data = mysqli_fetch_assoc($result_data)) {
            $list_reservations[] = $row_data;
        }
    }

    return $list_reservations;
}

/* =========================
   GET RESERVATION BY ID
========================= */
function getReservationById($conn, $id_reservation)
{
    $id_reservation = (int) $id_reservation;

    $sql_query = "
        SELECT
            r.*,
            u.name AS borrower_name,
            u.email AS borrower_email,
            f.name AS facility_name,
            f.kategori,
            f.deskripsi AS facility_desc,
            a.status AS approval_status,
            a.notes AS approval_notes,
            a.created_at AS approved_at,
            su.name AS supervisor_name
        FROM reservations r
        JOIN users u
            ON r.user_id = u.id
        JOIN facilities f
            ON r.facility_id = f.id
        LEFT JOIN approvals a
            ON r.id = a.reservation_id
        LEFT JOIN users su
            ON a.user_id = su.id
        WHERE r.id = $id_reservation
    ";

    $result_data = mysqli_query($conn, $sql_query);

    if ($result_data && mysqli_num_rows($result_data) > 0) {
        return mysqli_fetch_assoc($result_data);
    }

    return null;
}

/* =========================
   CANCEL RESERVATION
========================= */
function cancelReservation($conn, $id_reservation)
{
    $id_reservation = (int) $id_reservation;

    $sql_query = "
        UPDATE reservations
        SET status = 'dibatalkan'
        WHERE id = $id_reservation
    ";

    return mysqli_query($conn, $sql_query);
}

/* =========================
   DELETE RESERVATION
========================= */
function deleteReservation($conn, $id_reservation)
{
    $id_reservation = (int) $id_reservation;

    $sql_query = "
        DELETE FROM reservations
        WHERE id = $id_reservation
    ";

    return mysqli_query($conn, $sql_query);
}

/* =========================
   UPDATE RESERVATION
========================= */
function updateReservation(
    $conn,
    $id_reservation,
    $tanggal_baru,
    $jam_mulai_baru,
    $jam_selesai_baru,
    $catatan_baru
) {
    $id_reservation = (int) $id_reservation;

    $tanggal_baru = mysqli_real_escape_string(
        $conn,
        $tanggal_baru
    );

    $jam_mulai_baru = mysqli_real_escape_string(
        $conn,
        $jam_mulai_baru
    );

    $jam_selesai_baru = mysqli_real_escape_string(
        $conn,
        $jam_selesai_baru
    );

    $catatan_baru = mysqli_real_escape_string(
        $conn,
        $catatan_baru
    );

    $sql_query = "
        UPDATE reservations
        SET
            tanggal = '$tanggal_baru',
            jam_mulai = '$jam_mulai_baru',
            jam_selesai = '$jam_selesai_baru',
            notes = '$catatan_baru'
        WHERE id = $id_reservation
    ";

    return mysqli_query($conn, $sql_query);
}

/* =========================
   UPDATE STATUS
========================= */
function updateStatusReservasi($conn, $id, $status)
{
    $query = "
        UPDATE reservations
        SET status = ?
        WHERE id = ?
    ";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

?>