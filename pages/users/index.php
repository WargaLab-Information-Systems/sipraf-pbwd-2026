<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management</title>

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

                            <i class="fa-solid fa-building"></i>
                            Facilities
                        </a>

                        <a href="pages/users/index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                            <i class="fa-solid fa-users"></i>
                            Users
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

                            <i class="fa-solid fa-calendar-check"></i>
                            Peminjaman
                        </a>

                        <a href="pages/approval/index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                            <i class="fa-solid fa-circle-check"></i>
                            Persetujuan
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-10">

            <div>

                <h1 class="text-4xl font-bold text-gray-800">
                    User Management
                </h1>

                <p class="text-gray-500 mt-2">
                    Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus
                </p>

            </div>

            <!-- BUTTON -->
            <div class="flex gap-3 print:hidden">

                <button
                onclick="window.print()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow-lg">

                    <i class="fa-solid fa-print"></i>
                    Cetak PDF

                </button>

                <a href="pages/users/form.php"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-lg">

                    <i class="fa-solid fa-user-plus"></i>
                    Tambah User

                </a>
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl shadow-lg p-8 overflow-x-auto">

            <table class="w-full text-left">

                <thead>

                    <tr class="border-b text-gray-600">

                        <th class="pb-4">ID</th>
                        <th class="pb-4">Nama</th>
                        <th class="pb-4">Email</th>
                        <th class="pb-4">Role</th>
                        <th class="pb-4 print:hidden">
                        <div class="flex justify-center">Aksi</div></th>
                        </tr>

                    </tr>

                </thead>

                <tbody class="text-gray-700">

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">1</td>
                        <td>Admin SIPRAF</td>
                        <td>admin@sipraf.com</td>
                        <td>Admin</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">2</td>
                        <td>Reza Firmansyah</td>
                        <td>reza.firmansyah@sipraf.com</td>
                        <td>Supervisor</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">3</td>
                        <td>Dewi Kusuma</td>
                        <td>dewi.kusuma@sipraf.com</td>
                        <td>Supervisor</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">4</td>
                        <td>Hendra Saputra</td>
                        <td>hendra.saputra@sipraf.com</td>
                        <td>Supervisor</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">5</td>
                        <td>Siti Rahayu</td>
                        <td>siti.rahayu@sipraf.com</td>
                        <td>Supervisor</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">6</td>
                        <td>Bagas Wicaksono</td>
                        <td>bagas.wicaksono@sipraf.com</td>
                        <td>Supervisor</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">7</td>
                        <td>Fajar Nugroho</td>
                        <td>fajar.nugroho@sipraf.com</td>
                        <td>Borrower</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">8</td>
                        <td>Anisa Putri</td>
                        <td>anisa.putri@sipraf.com</td>
                        <td>Borrower</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">9</td>
                        <td>Dimas Ardiansyah</td>
                        <td>dimas.ardiansyah@sipraf.com</td>
                        <td>Borrower</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">10</td>
                        <td>Laila Maharani</td>
                        <td>laila.maharani@sipraf.com</td>
                        <td>Borrower</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
                            </a>
                        </div>
                    </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">11</td>
                        <td>Rizky Pratama</td>
                        <td>rizky.pratama@sipraf.com</td>
                        <td>Borrower</td>
                        <td class="print:hidden">
                        <div class="flex justify-center items-center gap-2">

                            <a href="detail.php"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="edit.php"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Hapus
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