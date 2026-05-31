<?php
require_once __DIR__ . '/../../helper/data/reservation.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (isset($_POST['update_reservation'])) {
    $borrower_name = mysqli_real_escape_string($conn, $_POST['borrower_name']);
    $borrower_email = mysqli_real_escape_string($conn, $_POST['borrower_email']);
    $facility_name = mysqli_real_escape_string($conn, $_POST['facility_name']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($conn, $_POST['jam_selesai']);
    
    $check_res = mysqli_query($conn, "SELECT user_id, facility_id FROM reservations WHERE id = $id");
    $res_old = mysqli_fetch_assoc($check_res);
    
    if ($res_old) {
        $user_id = $res_old['user_id'];
        $facility_id = $res_old['facility_id'];
        
        mysqli_query($conn, "UPDATE users SET name = '$borrower_name', email = '$borrower_email' WHERE id = $user_id");
        mysqli_query($conn, "UPDATE facilities SET name = '$facility_name' WHERE id = $facility_id");
        
        $update_sql = "UPDATE reservations SET 
                        tanggal = '$tanggal', 
                        jam_mulai = '$jam_mulai', 
                        jam_selesai = '$jam_selesai' 
                      WHERE id = $id";
        mysqli_query($conn, $update_sql);
    }
    
    header("Location: index.php");
    exit();
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'delete') {
        mysqli_query($conn, "DELETE FROM approvals WHERE reservation_id = $id");
        mysqli_query($conn, "DELETE FROM reservations WHERE id = $id");
        header("Location: index.php");
        exit();
    } elseif ($action === 'update') {
        mysqli_query($conn, "UPDATE reservations SET status = 'dibatalkan' WHERE id = $id");
        header("Location: index.php");
        exit();
    }
}

$query = "SELECT r.*, f.name AS facility_name, u.name AS borrower_name, u.email AS borrower_email, f.kategori 
          FROM reservations r
          JOIN facilities f ON r.facility_id = f.id
          JOIN users u ON r.user_id = u.id
          WHERE r.id = $id";
          
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: index.php");
    exit();
}

$is_editing = isset($_GET['mode']) && $_GET['mode'] === 'edit';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_editing ? 'Update Data Pengajuan' : 'Detail Pengajuan'; ?> - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex">

    <div class="w-64 flex-shrink-0">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/sipraf-pbwd-2026/includes/sidebar.php'; ?>
    </div>

    <div class="flex-1 p-8 overflow-y-auto flex items-center justify-center">

        <?php if (!$is_editing): ?>
        <div class="w-full max-w-3xl bg-gray-900 border border-gray-800 rounded-xl shadow-2xl p-6 relative">
            <div class="absolute top-6 right-6">
                <span class="inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider
                    <?php
                    if ($data['status'] == 'disetujui') echo 'bg-green-500/10 text-green-400 border border-green-500/20';
                    elseif ($data['status'] == 'ditolak') echo 'bg-red-500/10 text-red-400 border border-red-500/20';
                    elseif ($data['status'] == 'dibatalkan') echo 'bg-gray-500/10 text-gray-400 border border-gray-500/20';
                    else echo 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20';
                    ?>">
                    <?php echo htmlspecialchars($data['status']); ?>
                </span>
            </div>

            <div class="border-b border-gray-800 pb-4 mb-6">
                <h1 class="text-2xl font-bold tracking-wide text-white">Detail Pengajuan</h1>
                <p class="text-xs text-gray-400 mt-1">ID Pengajuan: #<?php echo $data['id']; ?></p>
            </div>

            <div class="space-y-6">
                <div class="border-b border-gray-800/60 pb-4">
                    <h2 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Informasi Peminjam</h2>
                    <p class="text-base font-semibold text-white"><?php echo htmlspecialchars($data['borrower_name']); ?></p>
                    <p class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($data['borrower_email'] ?? 'tidak_ada_email@sipraf.com'); ?></p>
                </div>

                <div class="grid grid-cols-2 gap-6 border-b border-gray-800/60 pb-4">
                    <div>
                        <h2 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Fasilitas / Ruangan</h2>
                        <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($data['facility_name']); ?> <span class="text-xs text-gray-400 uppercase">(<?php echo htmlspecialchars($data['kategori']); ?>)</span></p>
                    </div>
                    <div>
                        <h2 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Tanggal & Waktu</h2>
                        <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($data['tanggal']); ?></p>
                        <p class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($data['jam_mulai'] . ' - ' . $data['jam_selesai']); ?></p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Catatan Keperluan</h2>
                    <div class="bg-gray-950/40 border border-gray-800 p-3 rounded-lg text-sm text-gray-300 min-h-[50px]">
                        <?php echo htmlspecialchars($data['note'] ?? $data['keperluan'] ?? 'Tidak ada catatan keperluan khusus.'); ?>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 justify-center border-t border-gray-800 pt-5 mt-8">
                <a href="index.php" class="bg-gray-850 hover:bg-gray-800 text-gray-300 border border-gray-700 px-4 py-2 rounded text-xs font-semibold transition-colors">
                    Kembali
                </a>

                <?php if ($data['status'] == 'diajukan'): ?>
                    <a href="detail.php?action=update&id=<?php echo $data['id']; ?>" onclick="return confirm('Batalkan pengajuan ini?')" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded text-xs font-semibold transition-colors">
                        Batalkan Pengajuan
                    </a>
                    <a href="detail.php?id=<?php echo $data['id']; ?>&mode=edit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded text-xs font-semibold transition-colors">
                        Edit Data
                    </a>
                    <a href="detail.php?action=delete&id=<?php echo $data['id']; ?>" onclick="return confirm('Hapus permanen data ini?')" class="bg-red-650 hover:bg-red-700 text-white px-4 py-2 rounded text-xs font-semibold transition-colors">
                        Hapus Data
                    </a>
                <?php endif; ?>

                <?php if ($data['status'] == 'dibatalkan'): ?>
                    <a href="detail.php?action=delete&id=<?php echo $data['id']; ?>" onclick="return confirm('Hapus permanen data ini?')" class="bg-red-650 hover:bg-red-700 text-white px-4 py-2 rounded text-xs font-semibold transition-colors">
                        Hapus Data
                    </a>
                <?php endif; ?>
                
                </div>
        </div>

        <?php else: ?>
        <div class="w-full max-w-2xl bg-gray-900 border border-gray-800 rounded-xl shadow-2xl p-6">
            <div class="border-b border-gray-800 pb-3 mb-6">
                <h1 class="text-2xl font-bold text-white tracking-wide">Update Data Pengajuan</h1>
                <p class="text-xs text-gray-400 mt-1">Silakan sesuaikan data peminjaman di bawah ini</p>
            </div>
            
            <form action="" method="POST" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Peminjam</label>
                        <input type="text" name="borrower_name" value="<?php echo htmlspecialchars($data['borrower_name']); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email Peminjam</label>
                        <input type="email" name="borrower_email" value="<?php echo htmlspecialchars($data['borrower_email'] ?? ''); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Fasilitas / Ruangan / Barang</label>
                    <input type="text" name="facility_name" value="<?php echo htmlspecialchars($data['facility_name']); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="<?php echo htmlspecialchars($data['jam_mulai']); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="<?php echo htmlspecialchars($data['jam_selesai']); ?>" class="w-full bg-gray-950 border border-gray-800 rounded-lg p-2.5 text-sm text-gray-200 focus:outline-none focus:border-yellow-600" required>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-800">
                    <a href="detail.php?id=<?php echo $id; ?>" class="bg-gray-850 hover:bg-gray-800 text-gray-300 border border-gray-700 px-4 py-2 rounded text-xs font-semibold transition-colors">
                        Batal
                    </a>
                    <button type="submit" name="update_reservation" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded text-xs font-bold transition-colors shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>