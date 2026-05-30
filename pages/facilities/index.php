<?php
require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/facility.php';

$facilities = getAllFacilities($conn);

$totalRuangan = 0;

// Cek satu-satu isi datanya
foreach ($facilities as $row) {
    // Kalau kategorinya 'ruang' atau 'lab', tambahkan 1 ke hitungan
    if (strtolower($row['kategori']) == 'ruang' || strtolower($row['kategori']) == 'lab') {
        $totalRuangan++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAF - Fasilitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <aside class="w-72 bg-white shadow-xl p-6 print:hidden">
        <h1 class="text-3xl font-bold text-green-700 mb-10">
            SIPRAF
        </h1>
        <nav class="space-y-3">
            <a href="dashboard/index.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-gray-100">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="form.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-gray-100">
                <i class="fa-solid fa-plus"></i> Tambah Fasilitas
            </a>
            <a href="index.php" class="flex items-center gap-3 p-4 rounded-xl bg-green-100 text-green-700 font-semibold">
                <i class="fa-solid fa-file-lines"></i> Data Fasilitas
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8">

        <div class="flex justify-between items-center mb-10">
            <div>
              <h1 class="text-4xl font-bold text-gray-800">Manajemen Fasilitas</h1>
              <p class="text-gray-500 mt-2">Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus</p>
            </div>
            <button onclick="window.print()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow-lg print:hidden flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak PDF
            </button>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm print:hidden" role="alert">
                    <strong class="font-bold"><i class="fa-solid fa-check-circle mr-1"></i> Berhasil!</strong>
                    <span class="block sm:inline">Data fasilitas telah berhasil disimpan.</span>
                </div>
            <?php elseif ($_GET['status'] == 'deleted'): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm print:hidden" role="alert">
                    <strong class="font-bold"><i class="fa-solid fa-trash-can mr-1"></i> Dihapus!</strong>
                    <span class="block sm:inline">Data fasilitas telah berhasil dihapus.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 print:hidden">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500">Total Ruangan</p>
                <h2 class="text-4xl font-bold mt-2"><?= $totalRuangan ?></h2>
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
                <h2 class="text-4xl font-bold mt-2"><?= count($facilities) ?></h2>
            </div>
        </div>

        <div class="flex justify-between items-center mb-6 print:hidden">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Fasilitas</h2>
    
            <div class="flex">
                <input type="text" id="searchInput" placeholder="Cari fasilitas, kategori, kapasitas, atau status..." 
                        class="border border-gray-300 px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 w-96">
            </div>
        </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-200 text-gray-600 uppercase text-sm tracking-wider">
                            <th class="pb-4 font-semibold">No</th>
                            <th class="pb-4 font-semibold">Nama Fasilitas</th>
                            <th class="pb-4 font-semibold">Kategori</th>
                            <th class="pb-4 font-semibold">Kapasitas</th>
                            <th class="pb-4 font-semibold">Status</th>
                            <th class="pb-4 font-semibold print:hidden text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php 
                        $no = 1; 
                        if(count($facilities) > 0):
                            foreach ($facilities as $row): 
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4"><?= $no++ ?></td>
                            <td class="py-4 font-bold text-gray-800"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="py-4 capitalize"><?= htmlspecialchars($row['kategori']) ?></td>
                            <td class="py-4"><?= htmlspecialchars($row['kapasitas']) ?> Unit/Orang</td>
                            <td class="py-4">
                                <?php if (strtolower($row['status']) == 'tersedia' || strtolower($row['status']) == 'available'): ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-circle-check"></i> Tersedia
                                    </span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-circle-xmark"></i> <?= htmlspecialchars(ucfirst($row['status'])) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 print:hidden">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="form.php?id=<?= $row['id'] ?>" 
                                       class="bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-blue-200 hover:border-transparent">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="../../logic/facility_process.php?action=delete&id=<?= $row['id'] ?>" 
                                       onclick="return confirm('Apakah kamu yakin ingin menghapus data fasilitas <?= htmlspecialchars($row['name']) ?>?')"
                                       class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-red-200 hover:border-transparent">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </a>
                                    <a href="detail.php?id=<?= $row['id'] ?>" 
                                       class="bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white px-3 py-2 rounded-lg transition text-sm flex items-center gap-1 font-medium border border-emerald-200 hover:border-transparent">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                                Belum ada data fasilitas yang ditambahkan.
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
    // --- FITUR LIVE SEARCH ---
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            if (row.classList.contains('border-b')) {
                let rowText = row.textContent.toLowerCase();
                if (rowText.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // --- FITUR BERSIHKAN URL & AUTO HIDE NOTIFIKASI ---
    
    // 1. Bersihkan ?status=success dari URL tanpa refresh
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('status')) {
            url.searchParams.delete('status');
            window.history.replaceState({ path: url.href }, '', url.href);
        }
    }

    // 2. Hilangkan kotak notifikasi otomatis setelah 3 detik (opsional tapi keren)
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            // Animasi memudar
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            
            // Hapus elemen setelah animasi selesai
            setTimeout(() => alert.remove(), 500); 
        }, 3000); // 3000 ms = 3 detik
    });
</script>
</body>
</html>