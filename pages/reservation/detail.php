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

$error_message = isset($error_message) && $error_message !== '' ? $error_message : '';
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

<body class="bg-slate-50 text-slate-800 font-sans flex min-h-screen">

    <body class="bg-gray-100">

        <div class="flex min-h-screen">


            <!-- SIDEBAR -->
            <?php include '../../includes/sidebar.php' ?>

        </div>


        <!-- CONTENT -->
        <main class="flex-1 p-8">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Detail Reservation
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Informasi lengkap peminjaman fasilitas
                    </p>
                </div>

                <?php
                if ($data['status'] == 'disetujui') {
                    echo "<span class='bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium'>✅ Disetujui</span>";
                } elseif ($data['status'] == 'ditolak') {
                    echo "<span class='bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium'>❌ Ditolak</span>";
                } else {
                    echo "<span class='bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium'>⏳ Diajukan</span>";
                }
                ?>
            </div>


            <!-- DETAIL GRID -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Peminjam -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        👤 Data Peminjam
                    </h2>

                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-500">Nama</span><br>
                            <span class="font-medium"><?= $data['peminjam'] ?></span>
                        </p>

                        <p>
                            <span class="text-gray-500">Email</span><br>
                            <span class="font-medium"><?= $data['email'] ?></span>
                        </p>
                    </div>
                </div>


                <!-- Fasilitas -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        🏢 Data Fasilitas
                    </h2>

                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-500">Fasilitas</span><br>
                            <span class="font-medium"><?= $data['fasilitas'] ?></span>
                        </p>

                        <p>
                            <span class="text-gray-500">Kategori</span><br>
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                <?= ucfirst($data['kategori']) ?>
                            </span>
                        </p>

                        <p>
                            <span class="text-gray-500">Kapasitas</span><br>
                            <span class="font-medium">
                                <?= $data['kapasitas'] ?> Orang
                            </span>
                        </p>
                    </div>
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

</html>