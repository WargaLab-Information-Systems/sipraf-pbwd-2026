<?php

function getUsers($conn) {

    $query = mysqli_query($conn, "SELECT * FROM users");

    return $query;

}

function getUserById($conn, $user_id) {
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");

    return mysqli_fetch_assoc($query); // Mengembalikan array data
}
?>