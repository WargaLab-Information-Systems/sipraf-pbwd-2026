<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pages Facilities Index</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
<aside class="w-72 bg-white border-r shadow-sm flex flex-col justify-between print:hidden">

    <!-- TOP -->
    <div>

        <!-- LOGO -->
        <div class="p-8 border-b">

            <h1 class="text-4xl font-bold text-center text-black">
                SIPRAF
            </h1>

        </div>

        <!-- MENU -->
        <div class="p-6">

            <!-- DASHBOARD -->
            <div class="mb-10">

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Dashboard
                </p>

                <a href="pages/dashboard/index.php"
class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

    <i class="fa-solid fa-chart-line text-gray-600"></i>

    <span class="font-medium text-gray-700">
        Dashboard
    </span>

</a>

            </div>

            <!-- MASTER DATA -->
            <div class="mb-10">

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Master Data
                </p>

                <div class="space-y-2">

                    <a href="pages/facilities/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold">

                        <i class="fa-solid fa-building"></i>Facilities
                    </a>

                    <a href="pages/users/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-users"></i>Users
                    </a>

                </div>

            </div>

            <!-- FEATURE -->
            <div>

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Feature
                </p>

                <div class="space-y-2">

                    <a href="pages/reservation/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-calendar-check"></i>Peminjaman
                    </a>

                    <a href="pages/approval/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-circle-check"></i>Persetujuan
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- BOTTOM -->
    <div class="p-6 border-t">

        <div class="flex items-center justify-between">

            <!-- PROFILE -->
            <a href="pages/profile/index.php"
            class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-full bg-gray-300"></div>

                <div>

                    <h2 class="font-semibold text-gray-700">
                        Profile_name
                    </h2>
                </div>

            </a>

            <!-- LOGOUT -->
            <button
            class="w-10 h-10 rounded-full bg-gray-200 hover:bg-red-500 hover:text-white transition">

                <i class="fa-solid fa-right-from-bracket"></i>

            </button>

        </div>

    </div>

</aside>

    <!-- MAIN -->
    <main class="flex-1 p-8">

<!-- HEADER -->
<div class="flex justify-between items-center mb-10">

    <div>

      <h1 class="text-4xl font-bold text-gray-800">
        Detail Fasilitas Kampus
      </h1>

      <p class="text-gray-500 mt-2">
        Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus
      </p>

    </div>

    <!-- BUTTON -->
    <div class="flex gap-3 print:hidden">

        <!-- CETAK PDF -->
        <button
        onclick="window.print()"
        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow-lg">

            <i class="fa-solid fa-print"></i>
            Cetak PDF

        </button>

        <!-- TAMBAH DATA -->
        <a href="form.php"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-lg">

            <i class="fa-solid fa-plus"></i>
            Tambah Data

        </a>

    </div>

</div>

        <!-- CARD -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Ruangan</p>
                <h2 class="text-4xl font-bold mt-2">7</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Reservasi</p>
                <h2 class="text-4xl font-bold mt-2">30</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">User</p>
                <h2 class="text-4xl font-bold mt-2">11</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Fasilitas</p>
                <h2 class="text-4xl font-bold mt-2">13</h2>
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <div class="flex justify-between items-center mb-6 print:hidden">

                <h2 class="text-2xl font-bold">
                    Data Fasilitas Kampus
                </h2>

                <input type="text"
                placeholder="Cari data..."
                class="border px-4 py-2 rounded-xl">

            </div>

            <table class="w-full text-left border-collapse">

                <thead>

                    <tr class="border-b text-gray-600">

                        <th class="pb-4">No</th>
                        <th class="pb-4">Nama</th>
                        <th class="pb-4">Kategori</th>
                        <th class="pb-4">Kapasitas</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 print:hidden">
                            <div class="flex justify-center translate-x-2">Aksi</div></th>
                        </tr>

                </thead>

                <tbody class="text-gray-700">

                    <!-- DATA -->

                    <tr class="border-b hover:bg-gray-50">
                        <td>1</td>
                        <td class="py-4 font-semibold">Lab TI</td>
                        <td>Laboratorium Teknologi Informasi</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>2</td>
                        <td class="py-4 font-semibold">Lab BIS</td>
                        <td>Laboratorium Bisnis dan Sistem Informasi</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>3</td>
                        <td class="py-4 font-semibold">RKBF 204</td>
                        <td>Ruang Kelas Lantai 2 Gedung B Fakultas</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>4</td>
                        <td class="py-4 font-semibold">RKBF 307</td>
                        <td>Ruang Kelas Lantai 3 Gedung B Fakultas</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>5</td>
                        <td class="py-4 font-semibold">RKBF 308</td>
                        <td>Ruang Kelas Lantai 3 Gedung B Fakultas</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>6</td>
                        <td class="py-4 font-semibold">RKBF 407</td>
                        <td>Ruang Kelas Lantai 4 Gedung B Fakultas</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>7</td>
                        <td class="py-4 font-semibold">RKBF 408</td>
                        <td>Ruang Kelas Lantai 4 Gedung B Fakultas</td>
                        <td>40 Orang</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>8</td>
                        <td class="py-4 font-semibold">Proyektor 01</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>9</td>
                        <td class="py-4 font-semibold">Proyektor 02</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>10</td>
                        <td class="py-4 font-semibold">Switch 01</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>11</td>
                        <td class="py-4 font-semibold">Switch 02</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>12</td>
                        <td class="py-4 font-semibold">Router 01</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td>13</td>
                        <td class="py-4 font-semibold">Router 02</td>
                        <td>Barang</td>
                        <td>1 Unit</td>
                        <td>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Tersedia
                            </span>
                        </td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>
                        </div>
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>