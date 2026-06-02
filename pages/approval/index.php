<?php
session_start();

$_SESSION['role']    = 'admin';
$_SESSION['user_id'] = 1;

require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/approval.php';
require_once __DIR__ . '/../../logic/approval_process.php';

// ambil role dan user_id dari session
$role    = $_SESSION['role']    ?? 'borrower';
$user_id = $_SESSION['user_id'] ?? 0;

// ambil nama user dari database berdasarkan user_id
$query_user  = mysqli_query($conn, "SELECT name FROM users WHERE id = $user_id");
$data_user   = mysqli_fetch_assoc($query_user);
$nama_user   = $data_user['name'] ?? 'User';

// ambil data approval sesuai role
$data_approval = ($role === 'admin' || $role === 'supervisor')
    ? getAllApproval($conn)
    : getApprovalByUser($conn, $user_id);

// laporan hanya untuk admin dan supervisor
$laporan = ($role === 'admin' || $role === 'supervisor') ? generateLaporan($conn) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Approval — SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f0f2f5] min-h-screen flex">

    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php' ?>

    <!-- KONTEN UTAMA -->
    <main class=" flex-1 p-6 md:p-8">

        <div class="mb-7">
            <p class="text-xs font-semibold text-indigo-500 tracking-widest uppercase mb-1">SIPRAF</p>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Keputusan Approval</h1>
            <p class="text-sm text-gray-400 mt-1">Daftar seluruh keputusan peminjaman fasilitas</p>
        </div>

        <!-- card statistik hanya admin dan supervisor -->
        <?php if ($laporan): ?>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">
            <?php
            // data kartu statistik laporan
            $kartu = [
                ['label' => 'Total Approval', 'nilai' => $laporan['total'],           'warna' => 'text-gray-800'],
                ['label' => 'Disetujui',      'nilai' => $laporan['total_disetujui'], 'warna' => 'text-green-600'],
                ['label' => 'Ditolak',        'nilai' => $laporan['total_ditolak'],   'warna' => 'text-red-500'],
            ];
            foreach ($kartu as $k): ?>
            <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm p-6 hover:shadow-md transition">
                <p class="text-xs text-gray-400 font-medium mb-1"><?= $k['label'] ?></p>
                <p class="text-3xl font-bold <?= $k['warna'] ?>"><?= $k['nilai'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- tabel riwayat approval -->
        <div class="bg-white rounded-2xl border border-[#eaedf0] shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">Daftar Riwayat</h2>
                <p class="text-xs text-gray-400 mt-0.5">Semua keputusan approval tercatat di sini</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-[#f7f8fa]">
                        <tr>
                            <?php foreach (['No','Fasilitas','Peminjam','Tanggal Pinjam','Waktu','Supervisor','Status','Tgl Approval','Aksi'] as $th): ?>
                            <th class="text-left text-[11px] font-semibold tracking-wider text-[#8a94a6] uppercase px-4 py-3 border-b border-[#eaedf0]"><?= $th ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no       = 1;
                    $ada_data = false;
                    while ($row = mysqli_fetch_assoc($data_approval)):
                        $ada_data  = true;
                        // cek status untuk menentukan warna badge
                        $disetujui = ($row['status_approval'] ?? '') === 'disetujui';
                    ?>
                    <tr class="border-b border-[#f2f4f7] hover:bg-[#f7f9fc]">
                        <td class="px-4 py-3 text-sm text-gray-400"><?= $no++ ?></td>
                        <td class="px-4 py-3">
                            <p class="text-sm font-semibold text-gray-700"><?= htmlspecialchars($row['nama_fasilitas'] ?? '-') ?></p>
                            <p class="text-xs text-gray-400"><?= ucfirst($row['kategori'] ?? '-') ?></p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['nama_peminjam'] ?? '-') ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?= !empty($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : '-' ?></td>
                        <td class="px-4 py-3 text-sm text-gray-500"><?= substr($row['jam_mulai'] ?? '00:00', 0, 5) ?> – <?= substr($row['jam_selesai'] ?? '00:00', 0, 5) ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['nama_supervisor'] ?? '-') ?></td>
                        <td class="px-4 py-3">
                            <?php if ($disetujui): ?>
                            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>Disetujui
                            </span>
                            <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Ditolak
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500"><?= !empty($row['tanggal_approval']) ? date('d M Y', strtotime($row['tanggal_approval'])) : '-' ?></td>
                        <td class="px-4 py-3">
                            <a href="detail.php?id=<?= $row['id'] ?>" class="inline-flex items-center bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">Detail →</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if (!$ada_data): ?>
                    <tr><td colspan="9" class="text-center py-10 text-sm text-gray-400">Belum ada data approval.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>