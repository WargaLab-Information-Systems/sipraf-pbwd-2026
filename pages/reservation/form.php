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
</head>

<body class="bg-[#f4f7fb]">

<div class="flex min-h-screen">

    <!-- sidebr -->

    <div class="w-64 bg-white shadow-md p-6">

        <h1 class="text-3xl font-bold text-green-600 mb-10">
            SIPRAF
        </h1>

        <ul class="space-y-3">

            <li>
                <a href="index.php"
                class="block bg-green-100 text-green-700 px-4 py-3 rounded-xl font-semibold">

                    Reservation

                </a>
            </li>

            <li>
                <a href="detail.php"
                class="block hover:bg-gray-100 px-4 py-3 rounded-xl text-gray-600">

                    Data Pengajuan

                </a>
            </li>

        </ul>

    </div>

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

                        <?php while($user = mysqli_fetch_assoc($users)) { ?>

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

                        <?php while($facility = mysqli_fetch_assoc($facilities)) { ?>

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

</body>
</html>