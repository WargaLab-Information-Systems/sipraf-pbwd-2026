<?php
require '../../helper/db_conn.php';

$id = (int) $_GET['id'];

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $query_hapus = "DELETE FROM reservations WHERE id = '$id'";
    $exec_hapus = mysqli_query($conn, $query_hapus);

    if ($exec_hapus) {
        header("Location: index.php");
        exit;
    } else {
        $error_message = 'Gagal menghapus data dari database.';
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'batal') {
    $query_batal = "UPDATE reservations SET status = 'dibatalkan' WHERE id = '$id'";
    $exec_batal = mysqli_query($conn, $query_batal);

    if ($exec_batal) {
        header("Location: index.php");
        exit;
    } else {
        $error_message = 'Gagal membatalkan pengajuan.';
    }
}

$query = mysqli_query($conn, "
    SELECT
        r.*,
        u.id AS user_id,
        u.name AS peminjam,
        u.email,
        f.name AS fasilitas,
        f.kategori,
        f.kapasitas,
        f.deskripsi
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN facilities f ON r.facility_id = f.id
    WHERE r.id='$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header('Location: index.php');
    exit;
}

$facilities_query = mysqli_query($conn, "SELECT id, name FROM facilities ORDER BY name ASC");

$is_edit = (isset($_GET['mode']) && $_GET['mode'] === 'edit' && $data['status'] === 'diajukan');

$error_message = isset($error_message) ? $error_message : '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_reservation'])) {
    $peminjam_name = mysqli_real_escape_string($conn, $_POST['peminjam_name']);
    $peminjam_email = mysqli_real_escape_string($conn, $_POST['peminjam_email']);
    $facility_id = (int)$_POST['facility_id'];
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($conn, $_POST['jam_selesai']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    if (strtotime($jam_selesai) <= strtotime($jam_mulai)) {
        $error_message = 'Jam Selesai tidak masuk akal! Jam selesai harus lebih lambat dari jam mulai.';
    } else {
        $user_id = $data['user_id'];
        $update_user = "UPDATE users SET name = '$peminjam_name', email = '$peminjam_email' WHERE id = '$user_id'";
        
        $update_res = "UPDATE reservations SET 
            facility_id = '$facility_id', 
            tanggal = '$tanggal', 
            jam_mulai = '$jam_mulai', 
            jam_selesai = '$jam_selesai',
            notes = '$notes' 
            WHERE id = '$id' AND status = 'diajukan'";
            
        if (mysqli_query($conn, $update_user) && mysqli_query($conn, $update_res)) {
            header("Location: index.php");
            exit;
        } else {
            $error_message = 'Gagal menyimpan perubahan data ke database.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? 'Edit Reservation' : 'Detail Reservation' ?> - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 text-slate-800 font-sans">

    <div class="flex min-h-screen">

        <?php include '../../includes/sidebar.php'; ?>

        <main class="flex-1 p-8">

            <?php if (!empty($error_message)): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">
                    ⚠️ <?= $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <?= $is_edit ? 'Formulir Edit Pengajuan' : 'Detail Reservation' ?>
                    </h1>
                    <p class="text-gray-500 mt-1">
                        <?= $is_edit ? 'Sesuaikan kembali jadwal penggunaan fasilitas' : 'Informasi lengkap peminjaman fasilitas' ?>
                    </p>
                </div>

                <?php if (!$is_edit): ?>
                    <div>
                        <?php
                        if ($data['status'] == 'disetujui') {
                            echo "<span class='bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium'>✅ Disetujui</span>";
                        } elseif ($data['status'] == 'ditolak') {
                            echo "<span class='bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium'>❌ Ditolak</span>";
                        } elseif ($data['status'] == 'dibatalkan') {
                            echo "<span class='bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium'>⚪ Dibatalkan</span>";
                        } else {
                            echo "<span class='bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium'>⏳ Diajukan</span>";
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($is_edit): ?>
                <div class="bg-white rounded-2xl shadow-sm border p-8 max-w-4xl">
                    <form action="" method="POST" id="editForm" onsubmit="return validateForm(event)">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Peminjam</label>
                                <input type="text" name="peminjam_name" class="w-full border border-gray-200 rounded-lg p-3 text-sm font-medium text-gray-800 focus:outline-none focus:border-blue-500 shadow-sm" value="<?= htmlspecialchars($data['peminjam']) ?>" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Peminjam</label>
                                <input type="email" name="peminjam_email" class="w-full border border-gray-200 rounded-lg p-3 text-sm font-medium text-gray-800 focus:outline-none focus:border-blue-500 shadow-sm" value="<?= htmlspecialchars($data['email']) ?>" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Fasilitas / Ruangan</label>
                                <select name="facility_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm bg-white focus:outline-none focus:border-blue-500 font-medium text-gray-800 shadow-sm" required>
                                    <?php while($f_row = mysqli_fetch_assoc($facilities_query)): ?>
                                        <option value="<?= $f_row['id']; ?>" <?= ($f_row['id'] == $data['facility_id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($f_row['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-blue-500 font-medium text-gray-800 shadow-sm" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                    <input type="time" id="jam_mulai" name="jam_mulai" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-blue-500 font-medium text-gray-800 shadow-sm" value="<?= htmlspecialchars(substr($data['jam_mulai'], 0, 5)) ?>" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                                    <input type="time" id="jam_selesai" name="jam_selesai" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-blue-500 font-medium text-gray-800 shadow-sm" value="<?= htmlspecialchars(substr($data['jam_selesai'], 0, 5)) ?>" required>
                                    <p id="time_warning" class="text-red-500 text-xs font-semibold mt-2 hidden">❌ Jam selesai tidak masuk akal! Harus lebih lambat dari jam mulai.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</label>
                                <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-blue-500 font-medium text-gray-800 shadow-sm"><?= htmlspecialchars($data['notes']) ?></textarea>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-8">
                            <a href="detail.php?id=<?= $id; ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                                Batal
                            </a>
                            <button type="submit" name="update_reservation" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

            <?php else: ?>
                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">👤 Data Peminjam</h2>
                        <div class="space-y-3">
                            <p>
                                <span class="text-gray-500">Nama</span><br>
                                <span class="font-medium"><?= htmlspecialchars($data['peminjam']) ?></span>
                            </p>
                            <p>
                                <span class="text-gray-500">Email</span><br>
                                <span class="font-medium"><?= htmlspecialchars($data['email']) ?></span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">🏢 Data Fasilitas</h2>
                        <div class="space-y-3">
                            <p>
                                <span class="text-gray-500">Fasilitas</span><br>
                                <span class="font-medium"><?= htmlspecialchars($data['fasilitas']) ?></span>
                            </p>
                            <p>
                                <span class="text-gray-500">Kategori</span><br>
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    <?= ucfirst(htmlspecialchars($data['kategori'])) ?>
                                </span>
                            </p>
                            <p>
                                <span class="text-gray-500">Kapasitas</span><br>
                                <span class="font-medium"><?= htmlspecialchars($data['kapasitas']) ?> Orang</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">📅 Jadwal Reservasi</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-gray-500 text-sm">Tanggal</p>
                                <p class="font-semibold text-lg"><?= date('d F Y', strtotime($data['tanggal'])) ?></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-gray-500 text-sm">Jam</p>
                                <p class="font-semibold text-lg">
                                    <?= substr($data['jam_mulai'], 0, 5) ?> - <?= substr($data['jam_selesai'], 0, 5) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">📝 Catatan Peminjam</h2>
                        <div class="bg-gray-50 border rounded-xl p-4 text-gray-700">
                            <?= !empty($data['notes']) ? htmlspecialchars($data['notes']) : 'Tidak ada catatan.' ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">📄 Deskripsi Fasilitas</h2>
                        <div class="bg-gray-50 border rounded-xl p-4 text-gray-700">
                            <?= !empty($data['deskripsi']) ? htmlspecialchars($data['deskripsi']) : 'Tidak ada deskripsi.' ?>
                        </div>
                    </div>

                </div>

                <div class="flex flex-wrap gap-3 mt-8">
                    <?php if ($data['status'] == 'diajukan' || empty($data['status'])): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                        <a href="detail.php?id=<?= $data['id'] ?>&action=batal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Batalkan Pengajuan
                        </a>
                        <a href="detail.php?id=<?= $data['id'] ?>&mode=edit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Edit Data
                        </a>
                        <a href="detail.php?id=<?= $data['id'] ?>&action=hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajuan ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Hapus Data
                        </a>

                    <?php elseif ($data['status'] == 'dibatalkan'): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                        <a href="detail.php?id=<?= $data['id'] ?>&action=hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajuan ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Hapus Data
                        </a>

                    <?php elseif ($data['status'] == 'disetujui' || $data['status'] == 'ditolak'): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </main>
    </div>

    <script>
    function validateForm(event) {
        const jamMulai = document.getElementById('jam_mulai').value;
        const jamSelesai = document.getElementById('jam_selesai').value;
        const warning = document.getElementById('time_warning');

        if (jamMulai && jamSelesai) {
            if (jamSelesai <= jamMulai) {
                event.preventDefault();
                warning.classList.remove('hidden');
                return false;
            }
        }
        warning.classList.add('hidden');
        return true;
    }

    document.getElementById('jam_mulai').addEventListener('input', function() {
        document.getElementById('time_warning').classList.add('hidden');
    });
    document.getElementById('jam_selesai').addEventListener('input', function() {
        document.getElementById('time_warning').classList.add('hidden');
    });
    </script>
</body>

</html>