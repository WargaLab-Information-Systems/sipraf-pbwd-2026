<?php
require_once __DIR__ . '/../../helper/db_conn.php';

// Ambil data reservation untuk kalender (read-only, aman)
$calendar_events = [];
$query = mysqli_query($conn, "SELECT reservation_date AS start, facility_name AS title FROM reservation");

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $calendar_events[] = [
            'title' => $row['title'],
            'start' => $row['start']
        ];
    }
}
?>

<div class="bg-white shadow rounded p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Reservation Calendar</h2>
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        events: <?= json_encode($calendar_events) ?>
    });
    calendar.render();
});
</script>