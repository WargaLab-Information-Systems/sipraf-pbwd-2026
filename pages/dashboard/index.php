<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../helper/db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex">
    <!-- Sidebar -->
    <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-2">Welcome to SIPRAF reservation dashboard</p>
        </div>

        <!-- Stat Cards -->
        <?php include 'stat_cards.php'; ?>

        <!-- Calendar -->
        <?php include 'calendar.php'; ?>
    </div>
</div>

</body>
</html>