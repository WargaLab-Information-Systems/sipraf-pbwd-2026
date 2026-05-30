<?php

function getFacilities($conn) {

    $query = mysqli_query($conn, "SELECT * FROM facilities");

    return $query;

}

?>