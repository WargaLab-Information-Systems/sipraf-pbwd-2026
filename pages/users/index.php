<?php
require_once __DIR__ . '/../../helper/db_conn.php';

$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAF - User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans">
<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php' ?>

        <!-- MAIN -->
        <main class="flex-1 p-10">

            <!-- HEADER -->
            <div class="flex justify-between items-start mb-10">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">User Management</h1>
                    <p class="text-gray-500 mt-2">Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus</p>
                </div>

                <div class="flex gap-3 print:hidden">
                    <button
                        onclick="window.print()"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow-lg">
                        <i class="fa-solid fa-print"></i>
                        Cetak PDF
                    </button>

                    <a href="form.php"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-lg">
                        <i class="fa-solid fa-user-plus"></i>
                        Tambah User
                    </a>
                </div>
            </div>

            <!-- KOTAK DAFTAR USER -->
            <div class="flex justify-between items-center mb-6 print:hidden">
                <h2 class="text-2xl font-bold text-gray-800">Daftar User</h2>
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Cari user..."
                        class="border border-gray-300 px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 w-96">
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6 print:hidden">
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-600">
                                <th class="pb-4">ID</th>
                                <th class="pb-4">Nama</th>
                                <th class="pb-4">Email</th>
                                <th class="pb-4">Role</th>
                                <th class="pb-4 print:hidden">
                                <td class="py-4 print:hidden">
                                    <div class="flex justify-center gap-2 font-bold">
                                        Aksi
                                    </div>
                                </td>
                            </tr>
                        </thead>

                        <tbody id="userTable">

                            <?php if (mysqli_num_rows($query) > 0): ?>

                                <?php while ($row = mysqli_fetch_assoc($query)): ?>

                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="py-4">
                                            <?= $row['id']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['name']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['email']); ?>
                                        </td>
                                        <td class="py-4">

                                            <?php
                                            switch (strtolower($row['role'])) {

                                                case 'admin':
                                                    echo '<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Admin
                                        </span>';
                                                    break;

                                                case 'supervisor':
                                                    echo '<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Supervisor
                                        </span>';
                                                    break;

                                                case 'borrower':
                                                    echo '<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Borrower
                                        </span>';
                                                    break;

                                                default:
                                                    echo '<span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">'
                                                        . htmlspecialchars($row['role']) .
                                                        '</span>';
                                            }
                                            ?>

                                        </td>

                                        <td>

                                        <td class="py-4 print:hidden text-center">
                                            <div class="flex justify-center gap-2">

                                                <a href="../profile/index.php?id=<?= $row['id']; ?>"
                                                    class="bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-emerald-200 hover:border-transparent">
                                                    <i class="fa-solid fa-eye"></i> Detail
                                                </a>

                                                <a href="form.php?id=<?= $row['id']; ?>"
                                                    class="bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-blue-200 hover:border-transparent">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </a>

                                                <a href="../../logic/user_process.php?action=delete&id=<?= $row['id']; ?>"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                    class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-red-200 hover:border-transparent">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </a>

                                            </div>
                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="5"
                                        class="text-center py-8 text-gray-500">Tidak ada data user

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {

            let keyword = this.value.toLowerCase();

            let rows = document.querySelectorAll("#userTable tr");

            rows.forEach(row => {

                let text = row.textContent.toLowerCase();

                row.style.display = text.includes(keyword) ? "" : "none";

            });

        });
    </script>

</body>

</html>