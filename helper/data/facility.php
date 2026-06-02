<?php
function getFacilities($conn) {

    $query = mysqli_query($conn, "SELECT * FROM facilities");

    return $query;

}

function getAllFacilities($conn) {
    $query = 'SELECT * FROM facilities ORDER BY id DESC';
    $result = mysqli_query($conn, $query);
    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

function getFacilityById($conn, $id) {
    $query = 'SELECT * FROM facilities WHERE id = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function insertFacility($conn, $data) {
    $query = 'INSERT INTO facilities (name, kategori, kapasitas, deskripsi, status) VALUES (?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssiss", $data['name'], $data['kategori'], $data['kapasitas'], $data['deskripsi'], $data['status']);
    return mysqli_stmt_execute($stmt);
}

function updateFacility($conn, $id, $data) {
    $query = 'UPDATE facilities SET name = ?, kategori = ?, kapasitas = ?, deskripsi = ?, status = ? WHERE id = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssissi", $data['name'], $data['kategori'], $data['kapasitas'], $data['deskripsi'], $data['status'], $id);
    return mysqli_stmt_execute($stmt);
}

function deleteFacility($conn, $id) {
    $query = 'DELETE FROM facilities WHERE id = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

function isFacilityInUse($conn, $id) {
    $query = 'SELECT COUNT(*) as count FROM reservations WHERE facility_id = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'] > 0;
}
?>