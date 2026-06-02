<?php
require '../../helper/db_conn.php';

$id = (int) $_GET['id'];

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

$error_message = '';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen m-0 p-0 overflow-hidden">

<div class="flex w-full h-screen">

    <!-- Sidebar -->
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

            <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
                <a href="../../pages/profile/index.php" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-sm group-hover:bg-blue-500 transition-colors">
                        U
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors leading-tight">Profile_name</span>
                        <span class="text-xs text-gray-400">User</span>
                    </div>
                </a>

                <a href="../../logic/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Logout">
                    <i class="fa-solid fa-right-from-bracket text-base"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 h-screen overflow-y-auto p-6 bg-gray-100">

        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 border border-gray-200">

            <?php if (!empty($error_message)): ?>
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    <?= $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        <?= $is_edit ? 'Formulir Edit Pengajuan' : 'Detail Reservation' ?>
                    </h1>
                    <p class="text-sm text-gray-500">
                        <?= $is_edit ? 'Sesuaikan kembali jadwal penggunaan fasilitas' : 'Informasi lengkap peminjaman fasilitas' ?>
                    </p>
                </div>
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

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <form action="" method="POST" id="editForm" onsubmit="return validateForm(event)">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Peminjam</label>
                                <input type="text" name="peminjam_name" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" value="<?= htmlspecialchars($data['peminjam']) ?>" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Peminjam</label>
                                <input type="email" name="peminjam_email" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" value="<?= htmlspecialchars($data['email']) ?>" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Fasilitas / Ruangan</label>
                                <select name="facility_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" required>
                                    <?php while($f_row = mysqli_fetch_assoc($facilities_query)): ?>
                                        <option value="<?= $f_row['id']; ?>" <?= ($f_row['id'] == $data['facility_id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($f_row['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                    <input type="time" id="jam_mulai" name="jam_mulai" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" value="<?= htmlspecialchars(substr($data['jam_mulai'], 0, 5)) ?>" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                                    <input type="time" id="jam_selesai" name="jam_selesai" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400" value="<?= htmlspecialchars(substr($data['jam_selesai'], 0, 5)) ?>" required>
                                    <p id="time_warning" class="text-red-500 text-xs font-semibold mt-2 hidden">
                                        ❌ Jam selesai tidak masuk akal! Harus lebih lambat dari jam mulai.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</label>
                                <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400"><?= htmlspecialchars($data['notes']) ?></textarea>
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

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">Data Peminjam</h2>
                                <p class="text-xs text-gray-400">Informasi pengguna peminjam</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Nama</p>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['peminjam']) ?></p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['email']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <i class="fa-solid fa-building-columns text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">Data Fasilitas</h2>
                                <p class="text-xs text-gray-400">Informasi fasilitas yang dipinjam</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Fasilitas</p>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['fasilitas']) ?></p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Kategori</p>
                                <span class="inline-flex bg-white border border-gray-200 px-3 py-1 rounded-full text-xs font-semibold text-gray-700">
                                    <?= ucfirst(htmlspecialchars($data['kategori'])) ?>
                                </span>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Kapasitas</p>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($data['kapasitas']) ?> Orang</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:col-span-2 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center">
                                <i class="fa-solid fa-calendar-days text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">Jadwal Reservasi</h2>
                                <p class="text-xs text-gray-400">Tanggal dan waktu penggunaan fasilitas</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                                <p class="font-semibold text-lg text-gray-800"><?= date('d F Y', strtotime($data['tanggal'])) ?></p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Jam</p>
                                <p class="font-semibold text-lg text-gray-800">
                                    <?= substr($data['jam_mulai'], 0, 5) ?> - <?= substr($data['jam_selesai'], 0, 5) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:col-span-2 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <i class="fa-solid fa-note-sticky text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">Catatan Peminjam</h2>
                                <p class="text-xs text-gray-400">Keperluan atau catatan tambahan</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-gray-700">
                            <?= !empty($data['notes']) ? htmlspecialchars($data['notes']) : 'Tidak ada catatan.' ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:col-span-2 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                                <i class="fa-solid fa-file-lines text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">Deskripsi Fasilitas</h2>
                                <p class="text-xs text-gray-400">Detail keterangan fasilitas</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-gray-700">
                            <?= !empty($data['deskripsi']) ? htmlspecialchars($data['deskripsi']) : 'Tidak ada deskripsi.' ?>
                        </div>
                    </div>

                </div>

                <div class="flex flex-wrap gap-3 mt-8">
                    <?php if ($data['status'] == 'diajukan' || empty($data['status'])): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                        <a href="../../logic/cancel_reservation.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Batalkan Pengajuan
                        </a>
                        <a href="detail.php?id=<?= $data['id'] ?>&mode=edit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Edit Data
                        </a>
                        <a href="../../logic/delete_reservation.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajuan ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Hapus Data
                        </a>

                    <?php elseif ($data['status'] == 'dibatalkan'): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                        <a href="../../logic/delete_reservation.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajuan ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                            Hapus Data
                        </a>

                    <?php elseif ($data['status'] == 'disetujui' || $data['status'] == 'ditolak'): ?>
                        <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-bold transition border border-gray-200">
                            Kembali
                        </a>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>
    </main>

</div>

<script>
function validateForm(event) {
    const jamMulai = document.getElementById('jam_mulai');
    const jamSelesai = document.getElementById('jam_selesai');
    const warning = document.getElementById('time_warning');

    if (!jamMulai || !jamSelesai || !warning) {
        return true;
    }

    if (jamMulai.value && jamSelesai.value) {
        if (jamSelesai.value <= jamMulai.value) {
            event.preventDefault();
            warning.classList.remove('hidden');
            return false;
        }
    }

    warning.classList.add('hidden');
    return true;
}

const jamMulaiInput = document.getElementById('jam_mulai');
const jamSelesaiInput = document.getElementById('jam_selesai');
const timeWarning = document.getElementById('time_warning');

if (jamMulaiInput && timeWarning) {
    jamMulaiInput.addEventListener('input', function() {
        timeWarning.classList.add('hidden');
    });
}

if (jamSelesaiInput && timeWarning) {
    jamSelesaiInput.addEventListener('input', function() {
        timeWarning.classList.add('hidden');
    });
}
</script>

</body>
</html>