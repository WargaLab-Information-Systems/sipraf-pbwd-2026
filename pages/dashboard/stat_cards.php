<?php
require_once __DIR__ . '/../../helper/data/dashboard.php';

$stats = get_dashboard_stats($conn);
?>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Users</h2>
        <p class="text-2xl font-bold"><?= $stats['total_user'] ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Facilities</h2>
        <p class="text-2xl font-bold"><?= $stats['total_facility'] ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Reservations</h2>
        <p class="text-2xl font-bold"><?= $stats['total_reservation'] ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Approvals</h2>
        <p class="text-2xl font-bold"><?= $stats['total_approval'] ?></p>
    </div>
</div>