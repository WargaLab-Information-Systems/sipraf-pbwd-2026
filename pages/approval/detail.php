<?php
session_start();

require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/approval.php';

// ambil role dan user_id dari session
$role    = $_SESSION['role']    ?? 'borrower';
$user_id = $_SESSION['user_id'] ?? 0;

// ambil nama user dari database berdasarkan user_id
$query_user = mysqli_query($conn, "SELECT name FROM users WHERE id = $user_id");
$data_user  = mysqli_fetch_assoc($query_user);
$nama_user  = $data_user['name'] ?? 'User';

// ambil id approval dari url
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) die("ID approval tidak valid.");

// ambil detail approval berdasarkan id
$data_detail = getDetailApproval($conn, $id);

if (!$data_detail) die("Data approval tidak ditemukan.");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Approval — SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f0f2f5] min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-white border-r border-[#eaedf0] shadow-sm flex flex-col fixed top-0 left-0">

        <!-- logo -->
        <div class="px-6 py-5 border-b border-[#eaedf0]">
            <p class="text-lg font-bold text-gray-800 tracking-tight">SIPRAF</p>
        </div>

        <!-- menu -->
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            <a href="../dashboard/index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-[#f0f2f5] hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1">Master Data</p>

            <a href="../facilities/index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-[#f0f2f5] hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Facilities
            </a>

            <a href="../users/index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-[#f0f2f5] hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Users
            </a>

            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1">Feature</p>

            <a href="../reservation/index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-[#f0f2f5] hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Peminjaman
            </a>

            <!-- aktif di halaman ini -->
            <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold bg-indigo-50 text-indigo-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Persetujuan
            </a>

        </nav>

        <!-- profile & logout -->
        <div class="px-4 py-4 border-t border-[#eaedf0]">
            <a href="../profile/index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#f0f2f5] transition">
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                    <?= strtoupper(substr($nama_user, 0, 1)) ?>
                </div>
                <span class="text-sm font-medium text-gray-700 truncate"><?= htmlspecialchars($nama_user) ?></span>
            </a>
            <a href="../../logic/auth_process.php?action=logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                Logout
            </a>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="ml-64 flex-1 p-6 md:p-8">

        <div class="mb-7 flex items-center gap-4">
            <a href="index.php" class="inline-flex items-center gap-1.5 bg-white text-indigo-500 border border-[#dde3f5] hover:bg-indigo-50 px-4 py-2 rounded-xl text-sm font-semibold transition">← Kembali</a>
            <div>
                <p class="text-xs font-semibold text-indigo-500 tracking-widest uppercase mb-0.5">SIPRAF</p>
                <h1 class="text-2xl font-bold text-gray-800">Detail Keputusan Approval</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- card keputusan approval -->
            <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-[#f0f2f5]">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Informasi Keputusan</p>
                        <p class="text-xs text-gray-400">Data hasil approval</p>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-3 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Status</span>
                        <?php if ($data_detail['status_approval'] === 'disetujui'): ?>
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-3 py-0.5 rounded-full text-xs font-bold"><span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>Disetujui</span>
                        <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-0.5 rounded-full text-xs font-bold"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Ditolak</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Supervisor</span>
                        <span class="font-semibold text-gray-700"><?= htmlspecialchars($data_detail['nama_supervisor']) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Email Supervisor</span>
                        <span class="font-semibold text-indigo-500"><?= htmlspecialchars($data_detail['email_supervisor']) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Tanggal Keputusan</span>
                        <span class="font-semibold text-gray-700"><?= date('d M Y, H:i', strtotime($data_detail['tanggal_approval'])) ?></span>
                    </div>
                    <div class="pt-1">
                        <p class="text-xs text-[#8a94a6] font-medium mb-1">Catatan Keputusan</p>
                        <div class="bg-[#f7f8fa] border border-[#eaedf0] rounded-xl px-4 py-3 text-sm text-gray-600 leading-relaxed"><?= htmlspecialchars($data_detail['catatan_approval']) ?></div>
                    </div>
                </div>
            </div>

            <!-- card reservasi -->
            <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-[#f0f2f5]">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Informasi Reservasi</p>
                        <p class="text-xs text-gray-400">Data pengajuan peminjaman</p>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Peminjam</span>
                        <span class="font-semibold text-gray-700"><?= htmlspecialchars($data_detail['nama_peminjam']) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Email Peminjam</span>
                        <span class="font-semibold text-indigo-500"><?= htmlspecialchars($data_detail['email_peminjam']) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Tanggal Pinjam</span>
                        <span class="font-semibold text-gray-700"><?= date('d M Y', strtotime($data_detail['tanggal'])) ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#f5f6f8]">
                        <span class="text-[#8a94a6] font-medium">Waktu</span>
                        <span class="font-semibold text-gray-700"><?= substr($data_detail['jam_mulai'], 0, 5) ?> – <?= substr($data_detail['jam_selesai'], 0, 5) ?></span>
                    </div>
                    <div class="pt-1">
                        <p class="text-xs text-[#8a94a6] font-medium mb-1">Catatan Reservasi</p>
                        <div class="bg-[#f7f8fa] border border-[#eaedf0] rounded-xl px-4 py-3 text-sm text-gray-600 leading-relaxed"><?= htmlspecialchars($data_detail['catatan_reservasi']) ?></div>
                    </div>
                </div>
            </div>

            <!-- card fasilitas full width -->
            <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm overflow-hidden md:col-span-2">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-[#f0f2f5]">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Informasi Fasilitas</p>
                        <p class="text-xs text-gray-400">Detail fasilitas yang dipinjam</p>
                    </div>
                </div>
                <div class="px-6 py-5 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                    <div><p class="text-xs text-gray-400 font-medium mb-1">Nama Fasilitas</p><p class="font-semibold text-gray-700"><?= htmlspecialchars($data_detail['nama_fasilitas']) ?></p></div>
                    <div><p class="text-xs text-gray-400 font-medium mb-1">Kategori</p><p class="font-semibold text-gray-700"><?= ucfirst($data_detail['kategori']) ?></p></div>
                    <div><p class="text-xs text-gray-400 font-medium mb-1">Kapasitas</p><p class="font-semibold text-gray-700"><?= $data_detail['kapasitas'] ?> orang</p></div>
                    <div><p class="text-xs text-gray-400 font-medium mb-1">Deskripsi</p><p class="font-semibold text-gray-700"><?= htmlspecialchars($data_detail['deskripsi_fasilitas']) ?></p></div>
                </div>
            </div>

        </div>

    </main>

</body>
</html>