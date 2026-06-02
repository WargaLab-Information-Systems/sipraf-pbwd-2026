<?php

function get_dashboard_stats($conn)
{
    $data = [];

    $query_user = mysqli_query($conn, "SELECT COUNT(*) AS total_user FROM users");
    $data['total_user'] = mysqli_fetch_assoc($query_user)['total_user'];

    $query_facility = mysqli_query($conn, "SELECT COUNT(*) AS total_facility FROM facilities");
    $data['total_facility'] = mysqli_fetch_assoc($query_facility)['total_facility'];

    $query_reservation = mysqli_query($conn, "SELECT COUNT(*) AS total_reservation FROM reservations");
    $data['total_reservation'] = mysqli_fetch_assoc($query_reservation)['total_reservation'];

    $query_approval = mysqli_query($conn, "SELECT COUNT(*) AS total_approval FROM approvals");
    $data['total_approval'] = mysqli_fetch_assoc($query_approval)['total_approval'];

    return $data;
}

function get_calendar_data($conn)
{
    $events = [];

    $query = mysqli_query($conn, "
        SELECT
            reservations.*,
            facilities.name AS facility_name
        FROM reservations
        LEFT JOIN facilities
        ON reservations.facility_id = facilities.id
    ");

    while ($row = mysqli_fetch_assoc($query)) {

        $statusColor = '#fef08a';

        if (isset($row['status'])) {
            $statusColor = [
                'diajukan'   => '#fef08a',
                'disetujui'  => '#bbf7d0',
                'ditolak'    => '#fecaca',
                'dibatalkan' => '#e5e7eb'
            ][$row['status']] ?? '#fef08a';
        }

        $events[] = [
            'title' => $row['facility_name'],
            'start' => $row['tanggal'],
            'color' => $statusColor
        ];
    }

    return $events;
}
