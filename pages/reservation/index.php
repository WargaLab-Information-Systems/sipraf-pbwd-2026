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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen m-0 p-0 overflow-hidden">

    <div class="flex w-full h-screen">
        
        <div class="w-64 flex-shrink-0 h-full">
            <div class="w-64 h-screen bg-white text-gray-700 flex flex-col justify-between border-r border-gray-200 font-sans">
    
                <div>
                    <div class="p-6 border-b border-gray-100 flex items-center justify-center">
                        <h1 class="text-2xl font-bold tracking-wider text-gray-950">SIPRAF</h1>
                    </div>

                    <nav class="p-4 space-y-6">
                        
                        <div>
                            <a href="../../pages/dashboard/index.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                <i class="fa-solid fa-chart-pie text-lg text-gray-400 w-5 text-center"></i>
                                Dashboard
                            </a>
                        </div>

                        <div>
                            <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Master Data</span>
                            <div class="space-y-1">
                                <a href="../../pages/facilities/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                    <i class="fa-solid fa-building text-lg text-gray-400 w-5 text-center"></i>
                                    Facilities
                                </a>
                                <a href="../../pages/users/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                    <i class="fa-solid fa-users text-lg text-gray-400 w-5 text-center"></i>
                                    Users
                                </a>
                            </div>
                        </div>

                        <div>
                            <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Feature</span>
                            <div class="space-y-1">
                                <a href="../../pages/reservation/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-emerald-50 text-emerald-600 transition-colors text-sm font-semibold">
                                    <i class="fa-solid fa-calendar-days text-lg text-emerald-500 w-5 text-center"></i>
                                    Peminjaman
                                </a>
                                <a href="../../pages/approval/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                    <i class="fa-solid fa-circle-check text-lg text-gray-400 w-5 text-center"></i>
                                    Persetujuan
                                </a>
                            </div>
                        </div>

                    </nav>
                </div>

                <div class="p-6 border-t">
            <div class="flex items-center justify-between">
                <a href="../profile/index.php"
                class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gray-300"></div>
                    <div>
                        <h2 class="font-semibold text-gray-700">Profile_name</h2>
                    </div>
                </a>

                <a href="../auth/logout.php"
                class="flex items-center gap-3">
                    <button
                    class="w-10 h-10 rounded-full bg-gray-200 hover:bg-red-500 hover:text-white">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
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
                            <i class="fa-solid fa-plus text-xs"></i>
                            Tambah Pengajuan
                        </a>
                        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-semibold transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-print text-xs"></i>
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