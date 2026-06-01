<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../helper/db_conn.php';
require_once '../../helper/data/dashboard.php';

// Ambil data
$stats = get_dashboard_stats($conn);
$calendar_events = get_calendar_data($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - SIPRAF</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<style>
body { font-family: 'Inter', sans-serif; }
.card:hover { transform: translateY(-4px); transition: all 0.2s; }
</style>
</head>
<body class="bg-gray-100 flex min-h-screen">

<!-- Sidebar -->
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<!-- Main Content -->
<div class="flex-1 p-10 space-y-8">
    
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-800 mb-1">Dashboard</h1>
        <p class="text-gray-500">Welcome to SIPRAF reservation dashboard</p>
    </div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

    <div class="card bg-indigo-100 p-6 rounded-xl shadow-md flex flex-col items-start">
        <h2 class="text-gray-500 mb-2">Total Users</h2>
        <p class="text-3xl font-bold text-indigo-600">
            <?= $stats['total_user'] ?>
        </p>
    </div>

    <div class="card bg-green-100 p-6 rounded-xl shadow-md flex flex-col items-start">
        <h2 class="text-gray-500 mb-2">Total Facilities</h2>
        <p class="text-3xl font-bold text-green-600">
            <?= $stats['total_facility'] ?>
        </p>
    </div>

    <div class="card bg-yellow-100 p-6 rounded-xl shadow-md flex flex-col items-start">
        <h2 class="text-gray-500 mb-2">Total Reservations</h2>
        <p class="text-3xl font-bold text-yellow-600">
            <?= $stats['total_reservation'] ?>
        </p>
    </div>

    <div class="card bg-red-100 p-6 rounded-xl shadow-md flex flex-col items-start">
        <h2 class="text-gray-500 mb-2">Total Approvals</h2>
        <p class="text-3xl font-bold text-red-600">
            <?= $stats['total_approval'] ?>
        </p>
    </div>

</div>

    <!-- Calendar -->
    <div class="bg-white shadow-md rounded-xl p-6 w-full overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">Reservation Calendar</h2>
        <div id="calendar" class="w-full"></div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 750,
        headerToolbar: {
            left: 'prev,next', // tombol today dihilangkan
            center: 'title',
            right: ''
        },
        events: <?= json_encode($calendar_events) ?>
    });
    calendar.render();
});
</script>

</body>
</html>