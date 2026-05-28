<?php
/**
 * File: pages/reservation/detail.php
 * Deskripsi: Modul All-in-One (Detail, Batal, Hapus, dan EDIT data dalam satu file!)
 */

session_start();
require_once __DIR__ . '/../../helper/data/reservation.php';

$id_detail = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$detail_pengajuan = getReservationById($conn, $id_detail);

if (!$detail_pengajuan) {
    header("Location: index.php");
    exit();
}

// Cek apakah user sedang menekan tombol "Edit" (Mengaktifkan Mode Edit)
$mode_edit = isset($_GET['mode']) && $_GET['mode'] === 'edit';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan #<?php echo $id_detail; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700">
        
        <div class="p-6 bg-gray-700 border-b border-gray-600 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold"><?php echo $mode_edit ? 'Form Edit Pengajuan' : 'Detail Pengajuan Reservasi'; ?></h2>
                <p class="text-xs text-gray-400 mt-1">ID Pengajuan: #<?php echo $id_detail; ?></p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?php
                if ($detail_pengajuan['status'] == 'disetujui') echo 'bg-green-900 text-green-300';
                elseif ($detail_pengajuan['status'] == 'dibatalkan') echo 'bg-gray-600 text-gray-300';
                else echo 'bg-yellow-950 text-yellow-300';
            ?>"><?php echo htmlspecialchars($detail_pengajuan['status']); ?></span>
        </div>

        <?php if ($mode_edit): ?>
            <form action="../../logic/reservation_process.php?action=update&id=<?php echo $id_detail; ?>" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-blue-400 mb-1">NAMA PEMINJAM</label>
                    <input type="text" name="borrower_name" value="<?php echo htmlspecialchars($detail_pengajuan['borrower_name']); ?>" class="w-full bg-gray-700 border border-gray-600 rounded p-2 text-white text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-blue-400 mb-1">EMAIL</label>
                    <input type="email" name="borrower_email" value="<?php echo htmlspecialchars($detail_pengajuan['borrower_email']); ?>" class="w-full bg-gray-700 border border-gray-600 rounded p-2 text-white text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-blue-400 mb-1">CATATAN KEPERLUAN</label>
                    <textarea name="notes" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded p-2 text-white text-sm focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($detail_pengajuan['notes']); ?></textarea>
                </div>
                
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-700">
                    <a href="detail.php?id=<?php echo $id_detail; ?>" class="bg-gray-600 hover:bg-gray-500 px-4 py-2 rounded text-sm font-medium">Batal Edit</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm font-medium text-white">Simpan Perubahan</button>
                </div>
            </form>

        <?php else: ?>
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="text-sm font-semibold text-blue-400 uppercase tracking-wider mb-2">Informasi Peminjam</h3>
                    <p class="text-base font-medium text-white"><?php echo htmlspecialchars($detail_pengajuan['borrower_name']); ?></p>
                    <p class="text-sm text-gray-400"><?php echo htmlspecialchars($detail_pengajuan['borrower_email']); ?></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-b border-gray-700 py-4">
                    <div>
                        <h4 class="text-xs text-gray-400 uppercase">Fasilitas / Ruangan</h4>
                        <p class="text-sm font-semibold text-white"><?php echo htmlspecialchars($detail_pengajuan['facility_name']); ?> (<?php echo htmlspecialchars($detail_pengajuan['kategori']); ?>)</p>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-400 uppercase">Tanggal & Waktu</h4>
                        <p class="text-sm font-semibold text-white"><?php echo htmlspecialchars($detail_pengajuan['tanggal'] . ' / ' . $detail_pengajuan['jam_mulai'] . ' - ' . $detail_pengajuan['jam_selesai']); ?></p>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-400 uppercase tracking-wider mb-1">Catatan Keperluan</h3>
                    <p class="text-sm text-gray-300 bg-gray-850 p-3 rounded border border-gray-700"><?php echo htmlspecialchars($detail_pengajuan['notes'] ?: '-'); ?></p>
                </div>
            </div>

            <div class="p-6 bg-gray-900 border-t border-gray-700 flex flex-wrap gap-3 justify-end">
                <a href="index.php" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-sm font-medium">Kembali</a>
                
                <?php if ($detail_pengajuan['status'] == 'diajukan'): ?>
                    <a href="../../logic/reservation_process.php?action=cancel&id=<?php echo $id_detail; ?>" onclick="return confirm('Batalkan pengajuan ini?')" class="bg-orange-600 hover:bg-orange-700 px-4 py-2 rounded text-sm font-medium">Batalkan Pengajuan</a>
                <?php endif; ?>

                <a href="detail.php?id=<?php echo $id_detail; ?>&mode=edit" class="bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded text-sm font-medium">Edit Data</a>

                <a href="../../logic/reservation_process.php?action=delete&id=<?php echo $id_detail; ?>" onclick="return confirm('Hapus permanen data ini?')" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-medium">Hapus Data</a>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>