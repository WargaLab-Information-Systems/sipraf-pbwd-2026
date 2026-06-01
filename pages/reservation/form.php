<?php

require_once '../../helper/db_conn.php';

require_once '../../helper/data/user.php';
require_once '../../helper/data/facility.php';

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

        <!-- Sidebar -->

        <div class="w-64 bg-white shadow-md flex flex-col justify-between">

            <div>

                <div class="p-6 border-b">

                    <h1 class="text-3xl font-bold text-center">
                        SIPRAF
                    </h1>

                </div>

                <div class="p-6">

                    <p class="text-xs text-gray-400 uppercase mb-3">
                        Dashboard
                    </p>

                    <a href="../dashboard/index.php"
                        class="block px-4 py-3 rounded-lg hover:bg-gray-100 mb-2">
                        Dashboard
                    </a>

                    <p class="text-xs text-gray-400 uppercase mt-6 mb-3">
                        Master Data
                    </p>

                    <a href="../facilities/index.php"
                        class="block px-4 py-3 rounded-lg hover:bg-gray-100 mb-2">
                        Facilities
                    </a>

                    <a href="../users/index.php"
                        class="block px-4 py-3 rounded-lg hover:bg-gray-100 mb-2">
                        Users
                    </a>

                    <p class="text-xs text-gray-400 uppercase mt-6 mb-3">
                        Feature
                    </p>

                    <a href="form.php"
                        class="block bg-green-100 text-green-700 font-semibold px-4 py-3 rounded-lg mb-2">
                        Peminjaman
                    </a>

                    <a href="../approval/index.php"
                        class="block px-4 py-3 rounded-lg hover:bg-gray-100">
                        Persetujuan
                    </a>

                </div>

            </div>

            <div class="p-6 border-t">

                <a href="../profile/index.php"
                    class="block mb-4 px-4 py-3 rounded-lg hover:bg-gray-100">
                    Profile
                </a>

                <a href="../../logout.php"
                    class="block text-center bg-red-500 text-white py-3 rounded-lg hover:bg-red-600">
                    Logout
                </a>

            </div>

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

            <div class="bg-white p-8 rounded-2xl shadow-sm w-full">

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

                        <!-- <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400"> -->

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            min="<?= date('Y-m-d'); ?>"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                    </div>

                    <!-- jam -->

                    <div class="grid grid-cols-2 gap-5 mb-5">

                        <div>

                            <label class="block mb-2 font-semibold text-gray-600">
                                Jam Mulai
                            </label>

                            <!-- <input
                        type="time"
                        name="jam_mulai"
                        id="jam_mulai"
                        class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400"> -->

                            <input
                                type="time"
                                name="jam_mulai"
                                id="jam_mulai"
                                min="07:00"
                                max="21:00"
                                class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400">

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold text-gray-600">
                                Jam Selesai
                            </label>

                            <!-- <input
                        type="time"
                        name="jam_selesai"
                        id="jam_selesai"
                        class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-400"> -->

                            <input
                                type="time"
                                name="jam_selesai"
                                id="jam_selesai"
                                min="07:00"
                                max="21:00"
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
                                        name="submit"
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

            <<<<<<< HEAD=======</div>

                <script>
                    document.querySelector("form").addEventListener("submit", function(e) {

                        let mulai = document.getElementById("jam_mulai").value;
                        let selesai = document.getElementById("jam_selesai").value;

                        if (mulai >= selesai) {

                            alert("Jam selesai harus lebih besar dari jam mulai");
                            e.preventDefault();

                        }

                    });
                </script>


                >>>>>>> origin/main
</body>

</html>