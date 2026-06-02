<?php
require_once __DIR__ . '/../../helper/data/reservation.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error_message = ""; 

if (isset($_POST['update_reservation'])) {
    $borrower_name = mysqli_real_escape_string($conn, $_POST['borrower_name']);
    $borrower_email = mysqli_real_escape_string($conn, $_POST['borrower_email']);
    $facility_id = intval($_POST['facility_id']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($conn, $_POST['jam_selesai']);
    
    // validasi Jam
    if (strtotime($jam_selesai) <= strtotime($jam_mulai)) {
        $error_message = "Validasi Gagal: Jam selesai tidak boleh mendahului atau sama dengan jam mulai!";
    } else {
        $check_res = mysqli_query($conn, "SELECT user_id FROM reservations WHERE id = $id");
        $res_old = mysqli_fetch_assoc($check_res);
        
        if ($res_old) {
            $user_id = $res_old['user_id'];
            mysqli_query($conn, "UPDATE users SET name = '$borrower_name', email = '$borrower_email' WHERE id = $user_id");
            
            $update_sql = "UPDATE reservations SET 
                            facility_id = $facility_id,
                            tanggal = '$tanggal', 
                            jam_mulai = '$jam_mulai', 
                            jam_selesai = '$jam_selesai' 
                          WHERE id = $id";
            mysqli_query($conn, $update_sql);
        }
        header("Location: index.php");
        exit();
    }
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

$facilities_query = mysqli_query($conn, "SELECT id, name FROM facilities ORDER BY name ASC");
$is_editing = isset($_GET['mode']) && $_GET['mode'] === 'edit';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIPRAF - Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans flex min-h-screen">

    <div class="w-64 bg-[#0B132B] text-white flex flex-col justify-between p-6 select-none shadow-xl shrink-0">
        <div>
            <div class="text-2xl font-bold tracking-wider mb-10 text-left px-3">
                SIPRAF
            </div>
            
            <nav class="space-y-6 text-sm">
                <div>
                    <a href="../dashboard/index.php" class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800/50 font-medium transition">
                        <i class="fa-solid fa-chart-pie text-lg w-5 text-center"></i>
                        Dashboard
                    </a>
                </div>

                <div class="space-y-1.5">
                    <div class="text-[11px] uppercase tracking-widest text-gray-500 font-bold mb-2 px-4">Master Data</div>
                    <a href="../facilities/index.php" class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-building text-lg w-5 text-center"></i>
                        Facilities
                    </a>
                    <a href="../users/index.php" class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-users text-lg w-5 text-center"></i>
                        Users
                    </a>
                </div>
                
                <div class="space-y-1.5">
                    <div class="text-[11px] uppercase tracking-widest text-gray-500 font-bold mb-2 px-4">Feature</div>
                    <a href="index.php" class="flex items-center gap-3 py-2.5 px-4 rounded-lg bg-[#1E3A8A] text-white font-medium shadow-md transition">
                        <i class="fa-solid fa-calendar-days text-lg w-5 text-center"></i>
                        Peminjaman
                    </a>
                    <a href="../approval/index.php" class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-circle-check text-lg w-5 text-center"></i>
                        Persetujuan
                    </a>
                </div>
            </nav>
        </div>
        
        <div class="border-t border-slate-800 pt-4 flex items-center justify-between px-2">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-sm text-white shadow-inner">
                    U
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-200">Profile_name</div>
                    <div class="text-xs text-gray-500">User</div>
                </div>
            </div>
            <button class="text-gray-500 hover:text-red-400 transition">
                <i class="fa-solid fa-right-from-bracket text-base"></i>
            </button>
        </div>
    </div>

    <div class="flex-1 p-10 flex items-center justify-center">
        <div class="w-full max-w-4xl bg-white p-8 rounded-xl shadow-sm border border-slate-200">

            <?php if (!$is_editing): ?>
                <div class="flex justify-between items-center mb-8 border-b pb-5">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Detail Pengajuan</h2>
                        <p class="text-xs text-slate-400 mt-1">ID Pengajuan: #<?php echo $data['id']; ?></p>
                    </div>
                    <div>
                        <?php 
                        $status_class = "bg-amber-50 text-amber-700 border-amber-200";
                        if ($data['status'] == 'disetujui') $status_class = "bg-emerald-50 text-emerald-700 border-emerald-200";
                        if ($data['status'] == 'ditolak') $status_class = "bg-rose-50 text-rose-700 border-rose-200";
                        if ($data['status'] == 'dibatalkan') $status_class = "bg-slate-100 text-slate-600 border-slate-200";
                        ?>
                        <span class="px-3 py-1.5 rounded-md text-xs font-bold uppercase border tracking-wider <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($data['status']); ?>
                        </span>
                    </div>
                </div>
                
                <table class="w-full mb-8 text-sm">
                    <tr class="border-b border-slate-100">
                        <td class="py-4 font-semibold w-1/3 text-slate-400 uppercase tracking-wider text-xs">Informasi Peminjam</td>
                        <td class="py-4 font-medium text-slate-800">
                            <div class="text-base font-semibold text-slate-900"><?php echo htmlspecialchars($data['borrower_name']); ?></div>
                            <div class="text-xs text-slate-400 font-normal mt-0.5"><?php echo htmlspecialchars($data['borrower_email']); ?></div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-4 font-semibold text-slate-400 uppercase tracking-wider text-xs">Fasilitas / Ruangan</td>
                        <td class="py-4 text-base font-bold text-slate-900"><?php echo htmlspecialchars($data['facility_name']); ?> <span class="text-xs font-normal text-slate-400 ml-1">(<?php echo strtoupper($data['kategori']); ?>)</span></td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-4 font-semibold text-slate-400 uppercase tracking-wider text-xs">Tanggal Pinjam</td>
                        <td class="py-4 font-medium text-slate-800 text-base"><?php echo htmlspecialchars($data['tanggal']); ?></td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-4 font-semibold text-slate-400 uppercase tracking-wider text-xs">Waktu / Jam</td>
                        <td class="py-4 font-medium text-slate-800 text-base"><?php echo htmlspecialchars($data['jam_mulai'] . ' - ' . $data['jam_selesai']); ?></td>
                    </tr>
                </table>

                <div class="flex gap-3 justify-start pt-2">
                    <a href="index.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-xs font-semibold transition shadow-sm">Kembali</a>

                    <?php if ($data['status'] == 'diajukan'): ?>
                        <a href="detail.php?action=update&id=<?php echo $data['id']; ?>" onclick="return confirm('Batalkan pengajuan ini?')" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-xs font-semibold transition shadow-sm">Batalkan Pengajuan</a>
                        <a href="detail.php?id=<?php echo $data['id']; ?>&mode=edit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-lg text-xs font-semibold transition shadow-sm">Edit Data</a>
                        <a href="detail.php?action=delete&id=<?php echo $data['id']; ?>" onclick="return confirm('Hapus permanen data ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-semibold transition shadow-sm">Hapus Data</a>
                    <?php endif; ?>

                    <?php if ($data['status'] == 'dibatalkan'): ?>
                        <a href="detail.php?action=delete&id=<?php echo $data['id']; ?>" onclick="return confirm('Hapus permanen data ini?')" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2.5 rounded-lg text-xs font-semibold transition shadow-sm">Hapus Data</a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <h2 class="text-xl font-bold mb-6 border-b pb-4 text-slate-900">Formulir Edit Pengajuan</h2>

                <?php if (!empty($error_message)): ?>
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-5 text-xs font-medium">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="POST" class="space-y-5 text-sm" id="formEdit">
                    <div>
                        <label class="block font-medium text-slate-700 mb-1.5">Nama Peminjam</label>
                        <input type="text" name="borrower_name" value="<?php echo htmlspecialchars($data['borrower_name']); ?>" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <div>
                        <label class="block font-medium text-slate-700 mb-1.5">Email Peminjam</label>
                        <input type="email" name="borrower_email" value="<?php echo htmlspecialchars($data['borrower_email']); ?>" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <div>
                        <label class="block font-medium text-slate-700 mb-1.5">Pilih Fasilitas / Ruangan</label>
                        <select name="facility_id" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <?php while($facility = mysqli_fetch_assoc($facilities_query)): ?>
                                <option value="<?php echo $facility['id']; ?>" <?php if($facility['id'] == $data['facility_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($facility['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-slate-700 mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-slate-700 mb-1.5">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="<?php echo htmlspecialchars($data['jam_mulai']); ?>" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        </div>
                        <div>
                            <label class="block font-medium text-slate-700 mb-1.5">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="<?php echo htmlspecialchars($data['jam_selesai']); ?>" class="w-full bg-white border border-slate-300 p-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <a href="detail.php?id=<?php echo $id; ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg transition">Batal</a>
                        <button type="submit" name="update_reservation" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>

                <script>
                document.getElementById('formEdit').addEventListener('submit', function(e) {
                    var startVal = document.getElementById('jam_mulai').value;
                    var endVal = document.getElementById('jam_selesai').value;
                    
                    if (startVal && endVal) {
                        var startTime = new Date("01/01/2026 " + startVal);
                        var endTime = new Date("01/01/2026 " + endVal);
                        
                        if (endTime <= startTime) {
                            e.preventDefault(); 
                            alert('Validasi Gagal: Jam selesai tidak boleh mendahului atau sama dengan jam mulai!');
                        }
                    }
                });
                </script>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>