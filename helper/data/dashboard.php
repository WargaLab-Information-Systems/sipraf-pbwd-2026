<?php

function get_dashboard_stats($conn)
{
    $data = [];

    // Total users
    $query_user = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total_user FROM users"
    );

    $data['total_user'] = mysqli_fetch_assoc(
        $query_user
    )['total_user'];

    // Total facility
    $query_facility = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total_facility FROM facilities"
    );

    $data['total_facility'] = mysqli_fetch_assoc(
        $query_facility
    )['total_facility'];

    // Total reservation
    $query_reservation = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total_reservation FROM reservations"
    );

    $data['total_reservation'] = mysqli_fetch_assoc(
        $query_reservation
    )['total_reservation'];

    // Total approval
    $query_approval = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total_approval FROM approvals"
    );

    $data['total_approval'] = mysqli_fetch_assoc(
        $query_approval
    )['total_approval'];

    return $data;
}

function get_calendar_data($conn)
{
    $events = [];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM reservation"
    );

    while ($row = mysqli_fetch_assoc($query)) {

        $events[] = [
            'title' => $row['facility_name'],
            'start' => $row['reservation_date']
        ];
    }

    return $events;
}
function get_recent_reservation($conn)
{
    $data = [];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM reservations
         ORDER BY id DESC
         LIMIT 5"
    );

    while ($row = mysqli_fetch_assoc($query)) {

        $data[] = $row;
    }

    return $data;
}
