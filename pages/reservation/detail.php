<?php

$conn = mysqli_connect("localhost", "root", "", "db_sipraf");

$query = mysqli_query($conn, "

SELECT
    reservations.*,
    users.name AS user_name,
    facilities.name AS facility_name

FROM reservations

JOIN users
ON reservations.user_id = users.id

JOIN facilities
ON reservations.facility_id = facilities.id

ORDER BY reservations.id DESC

");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reservation</title>

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
                class="block hover:bg-gray-100 px-4 py-3 rounded-xl text-gray-600">

                    Reservation

                </a>
            </li>

            <li>
                <a href="detail.php"
                class="block bg-green-100 text-green-700 px-4 py-3 rounded-xl font-semibold">

                    Data Pengajuan

                </a>
            </li>

        </ul>

    </div>

    <!-- konten -->

    <div class="flex-1 p-10">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-4xl font-bold text-gray-700 mb-2">
                    Data Pengajuan
                </h1>

                <p class="text-gray-500">
                    Daftar data reservation fasilitas
                </p>

            </div>

            <a href="index.php"
            class="bg-green-500 hover:bg-green-600 text-white px-6 py-4 rounded-xl font-semibold">

                + Tambahkan Pengajuan

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr class="text-gray-700">

                        <th class="p-5">No</th>
                        <th class="p-5">User</th>
                        <th class="p-5">Fasilitas</th>
                        <th class="p-5">Tanggal</th>
                        <th class="p-5">Jam</th>
                        <th class="p-5">Keperluan</th>
                        <th class="p-5">Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr class="border-b text-center hover:bg-gray-50">

                        <td class="p-5">
                            <?= $no++; ?>
                        </td>

                        <td class="p-5">
                            <?= $row['user_name']; ?>
                        </td>

                        <td class="p-5">
                            <?= $row['facility_name']; ?>
                        </td>

                        <td class="p-5">
                            <?= $row['tanggal']; ?>
                        </td>

                        <td class="p-5">
                            <?= $row['jam_mulai']; ?>
                            -
                            <?= $row['jam_selesai']; ?>
                        </td>

                        <td class="p-5">
                            <?= $row['notes']; ?>
                        </td>

                        <td class="p-5">

                            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm">

                                <?= $row['status']; ?>

                            </span>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
```