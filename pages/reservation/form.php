<?php
require '../../helper/db_conn.php';
require '../../helper/data/user.php';
require '../../helper/data/facility.php';

$users = getUsers($conn);
$facilities = getFacilities($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen m-0 p-0 overflow-hidden">

    <div class="flex min-h-screen">

        <!-- sidebr -->

        <?php include '../../includes/sidebar.php' ?>

        <!-- kontem -->

        <div class="flex-1 p-10">

            <!-- kotakotak -->

            <div class="grid grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 mb-2">
                        Total Pengajuan
                    </p>

                    <h1 class="text-4xl font-bold text-green-600">
                        12
                    </h1>

                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 mb-2">
                        Total Fasilitas
                    </p>

                    <h1 class="text-4xl font-bold text-blue-600">
                        13
                    </h1>

                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 mb-2">
                        Total User
                    </p>

                    <h1 class="text-4xl font-bold text-purple-600">
                        11
                    </h1>

                </div>

            </div>

            <!-- form -->

            <div class="bg-white p-8 rounded-2xl shadow-sm max-w-5xl">

                <div class="mb-8">

                    <h1 class="text-4xl font-bold text-gray-700 mb-2">
                        Form Pengajuan
                    </h1>

                    <p class="text-gray-500">
                        Silakan ajukan peminjaman fasilitas kampus
                    </p>

                </div>

                <form action="../../logic/reservation_process.php" method="POST">

                    <!-- user -->

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold text-gray-600">
                            Pilih User
                        </label>

                        <select
                            name="user_id"
                            id="user_id"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                            <option value="">-- Pilih User --</option>

                            <?php while ($user = mysqli_fetch_assoc($users)) { ?>

                                <option value="<?= $user['id']; ?>">
                                    <?= $user['name']; ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- facility -->

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold text-gray-600">
                            Pilih Fasilitas
                        </label>

                        <select
                            name="facility_id"
                            id="facility_id"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                            <option value="">-- Pilih Fasilitas --</option>

                            <?php while ($facility = mysqli_fetch_assoc($facilities)) { ?>

                                <option value="<?= $facility['id']; ?>">
                                    <?= $facility['name']; ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- tgl -->

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold text-gray-600">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                    </div>

                    <!-- jam -->

                    <div class="grid grid-cols-2 gap-5 mb-5">

                        <div>

                            <label class="block mb-2 font-semibold text-gray-600">
                                Jam Mulai
                            </label>

                            <input
                                type="time"
                                name="jam_mulai"
                                id="jam_mulai"
                                class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold text-gray-600">
                                Jam Selesai
                            </label>

                            <input
                                type="time"
                                name="jam_selesai"
                                id="jam_selesai"
                                class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                        </div>

                    </div>

                    <!-- keterangan -->

                    <div class="mb-6">

                        <label class="block mb-2 font-semibold text-gray-600">
                            Keperluan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="5"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>

                    </div>

                    <!-- button -->

                    <div class="flex items-center gap-4">

                        <button
                            type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-4 rounded-xl font-semibold">

                            Ajukan Peminjaman

                        </button>

                        <a href="detail.php"
                            class="text-green-600 font-semibold">

                            Lihat Data →

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
const form = document.getElementById('reservationForm');

function setInvalid(input, error) {
    input.classList.remove('border-gray-300', 'border-emerald-500');
    input.classList.add('border-red-500', 'focus:ring-red-400', 'focus:border-red-400');
    error.classList.remove('hidden');
}

function setValid(input, error) {
    input.classList.remove('border-red-500', 'focus:ring-red-400', 'focus:border-red-400');
    input.classList.add('border-emerald-500');
    error.classList.add('hidden');
}

function validateForm() {
    let valid = true;

    const user = document.getElementById('user_id');
    const facility = document.getElementById('facility_id');
    const tanggal = document.getElementById('tanggal');
    const mulai = document.getElementById('jam_mulai');
    const selesai = document.getElementById('jam_selesai');
    const notes = document.getElementById('notes');

    if (!user.value) {
        setInvalid(user, document.getElementById('errorUser'));
        valid = false;
    } else {
        setValid(user, document.getElementById('errorUser'));
    }

    if (!facility.value) {
        setInvalid(facility, document.getElementById('errorFacility'));
        valid = false;
    } else {
        setValid(facility, document.getElementById('errorFacility'));
    }

    if (!tanggal.value) {
        setInvalid(tanggal, document.getElementById('errorTanggal'));
        valid = false;
    } else {
        setValid(tanggal, document.getElementById('errorTanggal'));
    }

    if (!mulai.value) {
        setInvalid(mulai, document.getElementById('errorMulai'));
        valid = false;
    } else {
        setValid(mulai, document.getElementById('errorMulai'));
    }

    if (!selesai.value || (mulai.value && selesai.value && mulai.value >= selesai.value)) {
        setInvalid(selesai, document.getElementById('errorSelesai'));
        valid = false;
    } else {
        setValid(selesai, document.getElementById('errorSelesai'));
    }

    if (!notes.value.trim()) {
        setInvalid(notes, document.getElementById('errorNotes'));
        valid = false;
    } else {
        setValid(notes, document.getElementById('errorNotes'));
    }

    return valid;
}

form.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
    }
});

document.querySelectorAll('.input-field').forEach(function(input) {
    input.addEventListener('input', validateForm);
    input.addEventListener('change', validateForm);
});
</script>

</body>

</html>