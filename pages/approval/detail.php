<?php
session_start();

require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/approval.php';

// ambil role dari session
$role = $_SESSION['role'] ?? 'borrower';

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
<body class="bg-[#f0f2f5] min-h-screen p-6 md:p-8">

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
                <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-base"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list-icon lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg></div>
                <div>
                    <p class="text-sm font-semibold text-gray-700">Informasi Keputusan</p>
                    <p class="text-xs text-gray-400">Data hasil approval</p>
                </div>
            </div>
            <div class="px-6 py-5 space-y-3 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-[#f5f6f8]">
                    <span class="text-[#8a94a6] font-medium">Status</span>
                    <?php if ($data_detail['status_approval'] === 'disetujui'): ?>
                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-3 py-0.5 rounded-full text-xs font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>Disetujui
                    </span>
                    <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-0.5 rounded-full text-xs font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Ditolak
                    </span>
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
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-base"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg></div>
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

        <!-- card fasilitas -->
        <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm overflow-hidden md:col-span-2">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#f0f2f5]">
                <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center text-base"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2"><path d="M10 12h4"/><path d="M10 8h4"/><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/></svg></div>
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

</body>
</html>