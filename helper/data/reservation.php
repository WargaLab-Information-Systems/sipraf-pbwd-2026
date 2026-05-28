<?php

// mengubah status reservasi setelah keputusan approval dibuat
function updateStatusReservasi($conn, $id, $status) {
    $query = "UPDATE reservations SET status = ? WHERE id = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    return mysqli_stmt_execute($stmt);
}