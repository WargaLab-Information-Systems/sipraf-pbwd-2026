<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../logic/dashboard_process.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FullCalendar -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="pl-80 p-8">

        <!-- isi dashboard kamu -->

            <!-- Header -->
            <div class="mb-8">

                <h1 class="text-4xl font-bold text-gray-800">
                    Dashboard
                </h1>

                <p class="text-gray-500 mt-2">
                    Welcome to SIPRAF reservation dashboard
                </p>

            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- User -->
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 text-sm">
                                Total Users
                            </p>

                            <h2 class="text-4xl font-bold mt-2">
                                <?= $dashboard_stats['total_user']; ?>
                            </h2>

                        </div>

                        <div class="text-5xl">
                            
                        </div>

                    </div>

                </div>

                <!-- Facility -->
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 text-sm">
                                Total Facilities
                            </p>

                            <h2 class="text-4xl font-bold mt-2">
                                <?= $dashboard_stats['total_facility']; ?>
                            </h2>

                        </div>

                        <div class="text-5xl">
                            
                        </div>

                    </div>

                </div>

                <!-- Reservation -->
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 text-sm">
                                Total Reservations
                            </p>

                            <h2 class="text-4xl font-bold mt-2">
                                <?= $dashboard_stats['total_reservation']; ?>
                            </h2>

                        </div>

                        <div class="text-5xl">
                            
                        </div>

                    </div>

                </div>

                <!-- Approval -->
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 text-sm">
                                Total Approvals
                            </p>

                            <h2 class="text-4xl font-bold mt-2">
                                <?= $dashboard_stats['total_approval']; ?>
                            </h2>

                        </div>

                        <div class="text-5xl">
                            
                        </div>

                    </div>

                </div>

            </div>

            <!-- Calendar -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">

                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Reservation Calendar
                    </h2>

                    <div class="text-gray-400">
                        
                    </div>

                </div>

                <div id="calendar"></div>

            </div>
            <!-- Recent Reservation -->
<div class="bg-white rounded-2xl shadow-lg p-6 mt-8">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Recent Reservation
        </h2>

        <div class="text-gray-400">
            
        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-4">
                        ID
                    </th>

                    <th class="text-left py-4">
                        Reservation Date
                    </th>

                    <th class="text-left py-4">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($recent_reservation as $reservation) : ?>

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="py-4">
                            <?= $reservation['id']; ?>
                        </td>

                        <td class="py-4">
                            <?= $reservation['reservation_date']; ?>
                        </td>

                        <td class="py-4">

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                Active

                            </span>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

        </div>

    </div>

    <!-- FullCalendar JS -->
    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const calendar_element =
                    document.getElementById('calendar');

                const calendar =
                    new FullCalendar.Calendar(
                        calendar_element,
                        {
                            initialView: 'dayGridMonth',

                            height: 650,

                            events:
                            <?= json_encode($calendar_events); ?>
                        }
                    );

                calendar.render();
            }
        );

    </script>

</body>

</html>