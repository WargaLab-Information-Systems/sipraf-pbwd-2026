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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-[#f0f2f5] min-h-screen flex">

    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php' ?>

    <!-- KONTEN UTAMA -->
    <main class=" flex-1 p-6 md:p-8">

        <div class="mb-7 flex items-center gap-4">
            <a href="index.php" class="inline-flex items-center gap-1.5 bg-white text-indigo-500 border border-[#dde3f5] hover:bg-indigo-50 px-4 py-2 rounded-xl text-sm font-semibold transition">← Kembali</a>
            <div>
                <p class="text-xs font-semibold text-indigo-500 tracking-widest uppercase mb-0.5">SIPRAF</p>
                <h1 class="text-2xl font-bold text-gray-800">Detail Keputusan Approval</h1>
            </div>
        </div>

        <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 px-5 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); endif; ?>

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
                    <?php if ($role === 'admin' || ($role === 'supervisor' && $data_detail['email_supervisor'] === ($_SESSION['email'] ?? ''))): ?>
                    <button onclick="document.getElementById('modalEdit').classList.remove('hidden')"
                        class="ml-auto flex items-center gap-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <?php endif; ?>
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

    <?php if ($role === 'admin' || ($role === 'supervisor' && $data_detail['email_supervisor'] === ($_SESSION['email'] ?? ''))): ?>
    <!-- MODAL EDIT KEPUTUSAN -->
    <div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <!-- header modal -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#eaedf0]">
                <div>
                    <p class="text-sm font-bold text-gray-800">Edit Keputusan Approval</p>
                    <p class="text-xs text-gray-400">Ubah status dan catatan keputusan</p>
                </div>
                <button onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#f0f2f5] text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>
            </div>
            <!-- form -->
            <form action="../../logic/approval_process.php" method="POST" class="px-6 py-5 space-y-4">
                <input type="hidden" name="_action" value="edit_approval">
                <input type="hidden" name="id" value="<?= $data_detail['id'] ?>">

                <!-- status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                    <div class="flex gap-3">
                        <label class="flex-1 flex items-center gap-2.5 border rounded-xl px-4 py-2.5 cursor-pointer has-[:checked]:border-green-500 has-[:checked]:bg-green-50 transition">
                            <input type="radio" name="status" value="disetujui" class="accent-green-600"
                                <?= $data_detail['status_approval'] === 'disetujui' ? 'checked' : '' ?>>
                            <span class="text-sm font-medium text-gray-700">Disetujui</span>
                        </label>
                        <label class="flex-1 flex items-center gap-2.5 border rounded-xl px-4 py-2.5 cursor-pointer has-[:checked]:border-red-400 has-[:checked]:bg-red-50 transition">
                            <input type="radio" name="status" value="ditolak" class="accent-red-500"
                                <?= $data_detail['status_approval'] === 'ditolak' ? 'checked' : '' ?>>
                            <span class="text-sm font-medium text-gray-700">Ditolak</span>
                        </label>
                    </div>
                </div>

                <!-- catatan -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Catatan Keputusan</label>
                    <textarea name="notes" rows="4"
                        class="w-full border border-[#dde3f0] rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none"
                        placeholder="Tulis catatan keputusan..."><?= htmlspecialchars($data_detail['catatan_approval']) ?></textarea>
                </div>

                <!-- action buttons -->
                <div class="flex gap-3 pt-1">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="flex-1 border border-[#dde3f0] text-gray-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-[#f0f2f5] transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>