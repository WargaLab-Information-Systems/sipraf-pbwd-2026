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

<body class="bg-[#f8fafc]">

    <div class="flex min-h-screen">

        <?php include '../../includes/sidebar.php' ?>

        <div class="flex-1 p-10">

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-5xl mx-auto">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-[#1e293b] tracking-wide uppercase">
                        FORM PENGAJUAN PEMINJAMAN
                    </h1>
                    <p class="text-sm text-gray-400 mt-1">
                        Sistem Informasi Peminjaman Ruangan dan Fasilitas Kampus (SIPRAF)
                    </p>
                    <hr class="mt-5 border-gray-200">
                </div>

                <form action="../../logic/reservation_process.php" method="POST" class="space-y-5">

                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Pilih User
                        </label>
                        <select
                            name="user_id"
                            id="user_id"
                            class="w-full border border-gray-300 rounded-lg p-3 text-gray-500 bg-white focus:border-blue-500 focus:outline-none">
                            <option value="" class="text-gray-400">-- Pilih User --</option>
                            <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                                <option value="<?= $user['id']; ?>">
                                    <?= $user['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="facility_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Pilih Fasilitas
                        </label>
                        <select
                            name="facility_id"
                            id="facility_id"
                            class="w-full border border-gray-300 rounded-lg p-3 text-gray-500 bg-white focus:border-blue-500 focus:outline-none">
                            <option value="" class="text-gray-400">-- Pilih Fasilitas --</option>
                            <?php while ($facility = mysqli_fetch_assoc($facilities)) { ?>
                                <option value="<?= $facility['id']; ?>">
                                    <?= $facility['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                            Tanggal
                        </label>
                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            class="w-full border border-gray-300 rounded-lg p-3 text-gray-400 focus:border-blue-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="jam_mulai" class="block mb-2 text-sm font-medium text-gray-700">
                                Jam Mulai
                            </label>
                            <input
                                type="time"
                                name="jam_mulai"
                                id="jam_mulai"
                                class="w-full border border-gray-300 rounded-lg p-3 text-gray-400 focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="jam_selesai" class="block mb-2 text-sm font-medium text-gray-700">
                                Jam Selesai
                            </label>
                            <input
                                type="time"
                                name="jam_selesai"
                                id="jam_selesai"
                                class="w-full border border-gray-300 rounded-lg p-3 text-gray-400 focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-700">
                            Keperluan
                        </label>
                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            placeholder="Tuliskan keperluan peminjaman..."
                            class="w-full border border-gray-300 rounded-lg p-3 placeholder-gray-400 focus:border-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded shadow text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Ajukan Peminjaman
                        </button>

                        <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded shadow text-sm font-semibold transition-colors">
                            Lihat Data
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>