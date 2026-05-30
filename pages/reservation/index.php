<?php
require_once __DIR__ . '/../../helper/data/reservation.php';
$data_pengajuan = getAllReservations($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen m-0 p-0 overflow-hidden">

    <div class="flex w-full h-screen">

        <div class="w-64 flex-shrink-0 h-full">
            <div class="w-64 h-screen bg-gray-950 text-gray-300 flex flex-col justify-between border-r border-gray-800 font-sans">

                <div>
                    <div class="p-6 border-b border-gray-800 flex items-center justify-center">
                        <h1 class="text-2xl font-bold tracking-wider text-white">SIPRAF</h1>
                    </div>

                    <nav class="p-4 space-y-6">

                        <div>
                            <a href="../../pages/dashboard/index.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                                </svg>
                                Dashboard
                            </a>
                        </div>

                        <div>
                            <span class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Master Data</span>
                            <div class="space-y-1">
                                <a href="../../pages/facilities/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Facilities
                                </a>
                                <a href="../../pages/users/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Users
                                </a>
                            </div>
                        </div>

                        <div>
                            <span class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Feature</span>
                            <div class="space-y-1">
                                <a href="../../pages/reservation/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Peminjaman
                                </a>
                                <a href="../../pages/approval/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Persetujuan
                                </a>
                            </div>
                        </div>

                    </nav>
                </div>

                <div class="p-4 border-t border-gray-800 flex items-center justify-between bg-gray-900/50">
                    <a href="../../pages/profile/index.php" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-sm group-hover:bg-blue-500 transition-colors">
                            U
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors leading-tight">Profile_name</span>
                            <span class="text-xs text-gray-500">User</span>
                        </div>
                    </a>

                    <a href="../../logic/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" class="text-gray-500 hover:text-red-400 p-2 rounded-lg hover:bg-gray-800 transition-colors" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>

        <div class="flex-1 h-full overflow-y-auto p-6">

            <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 border border-gray-200">

                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">LAPORAN DATA PENGAJUAN</h1>
                        <p class="text-sm text-gray-500">Sistem Informasi Peminjaman Fasilitas (SIPRAF)</p>
                    </div>

                    <div class="flex gap-3 print:hidden">
                        <a href="form.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm font-semibold transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pengajuan
                        </a>
                        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-semibold transition-colors">
                            Cetak Laporan
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800 text-white text-sm">
                                <th class="p-3 border-r border-gray-700 text-center w-12">No</th>
                                <th class="p-3 border-r border-gray-700">Peminjam</th>
                                <th class="p-3 border-r border-gray-700">Fasilitas</th>
                                <th class="p-3 border-r border-gray-700">Kategori</th>
                                <th class="p-3 border-r border-gray-700">Tanggal</th>
                                <th class="p-3 border-r border-gray-700">Waktu</th>
                                <th class="p-3 border-r border-gray-700">Status</th>
                                <th class="p-3 text-center print:hidden">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                            <?php if (empty($data_pengajuan)): ?>
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-400 bg-gray-50">Belum ada data pengajuan.</td>
                                </tr>
                            <?php else: ?>
                                <?php $nomor_urut = 1; ?>
                                <?php foreach ($data_pengajuan as $row_data): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="p-3 border-r text-center"><?php echo $nomor_urut++; ?></td>
                                        <td class="p-3 border-r font-semibold"><?php echo htmlspecialchars($row_data['borrower_name']); ?></td>
                                        <td class="p-3 border-r"><?php echo htmlspecialchars($row_data['facility_name']); ?></td>
                                        <td class="p-3 border-r uppercase text-xs text-gray-500"><?php echo htmlspecialchars($row_data['kategori']); ?></td>
                                        <td class="p-3 border-r"><?php echo htmlspecialchars($row_data['tanggal']); ?></td>
                                        <td class="p-3 border-r"><?php echo htmlspecialchars($row_data['jam_mulai'] . ' - ' . $row_data['jam_selesai']); ?></td>
                                        <td class="p-3 border-r">
                                            <span class="px-2 py-0.5 rounded text-xs font-bold uppercase
                                                <?php
                                                if ($row_data['status'] == 'disetujui') echo 'bg-green-100 text-green-800';
                                                elseif ($row_data['status'] == 'ditolak') echo 'bg-red-100 text-red-800';
                                                elseif ($row_data['status'] == 'dibatalkan') echo 'bg-gray-100 text-gray-800';
                                                else echo 'bg-yellow-100 text-yellow-800';
                                                ?>">
                                                <?php echo htmlspecialchars($row_data['status']); ?>
                                            </span>
                                        </td>
                                        <td class="p-3 text-center print:hidden">
                                            <a href="detail.php?id=<?php echo $row_data['id']; ?>" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded text-xs font-medium transition-colors">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

</body>

</html>