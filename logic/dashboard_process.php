<?php

include __DIR__ . '/../helper/db_conn.php';
include __DIR__ . '/../helper/data/dashboard.php';

$dashboard_stats = get_dashboard_stats($conn);

$calendar_events = get_calendar_data($conn);

$recent_reservation = get_recent_reservation($conn);