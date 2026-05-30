<?php

function getUsers($conn) {

    $query = mysqli_query($conn, "SELECT * FROM users");

    return $query;

}

?>