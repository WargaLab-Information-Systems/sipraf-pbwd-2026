<?php
session_start();

// --- UNTUK TESTING SAJA (HAPUS NANTI JIKA FITUR LOGIN SUDAH JALAN) ---
$_SESSION['user_id'] = 7; 
// ------------------------------------------------------

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../../helper/db_conn.php';
require_once '../../helper/data/user.php';

// 1. Ambil data user
$user_id = $_SESSION['user_id'];
$user = getUserById($conn, $user_id);

// 2. Ambil data riwayat terakhir
$query_riwayat = "SELECT r.tanggal, r.status, f.name AS fasilitas_nama 
                  FROM reservations r 
                  JOIN facilities f ON r.facility_id = f.id 
                  WHERE r.user_id = ? 
                  ORDER BY r.created_at DESC LIMIT 1";
$stmt = mysqli_prepare($conn, $query_riwayat);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$riwayat_terakhir = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// merubah Role
$role_tampil = 'Tidak Diketahui';
if ($user['role'] == 'borrower') $role_tampil = 'Pemohon (Mahasiswa/Dosen)';
if ($user['role'] == 'supervisor') $role_tampil = 'PJ Fasilitas';
if ($user['role'] == 'admin') $role_tampil = 'Administrator';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Saya – SIPRAF</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen py-10 px-4">

  <div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex justify-between items-center">
      <a href="../dashboard/index.php" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 hover:bg-slate-50 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
      </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      
      <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

      <div class="p-6 relative pt-0 flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-100">
        <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-16 sm:-mt-12">
          <div class="w-24 h-24 bg-slate-200 rounded-2xl border-4 border-white shadow-md flex items-center justify-center text-slate-400 overflow-hidden">
            <?php if (!empty($user['foto'])): ?>
                <img src="../../assets/img/<?= htmlspecialchars($user['foto']) ?>" alt="Foto Profil" class="w-full h-full object-cover">
            <?php else: ?>
                <i class="fa-solid fa-user text-4xl"></i>
            <?php endif; ?>
          </div>
          <div class="text-center sm:text-left">
            <h1 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($user['name']) ?></h1>
            <p class="text-sm font-medium text-slate-500"><?= htmlspecialchars($user['email']) ?></p>
          </div>
        </div>

        <div class="shrink-0 flex justify-center" id="btnEditContainer">
          <button onclick="toggleEditMode(true)" class="flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-[13px] font-bold transition shadow-sm">
            <i class="fa-regular fa-pen-to-square"></i> Edit Profil
          </button>
        </div>
      </div>

      <div id="viewMode" class="p-6 space-y-6 block">
        <div>
          <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-id-card text-emerald-600"></i> Informasi Akun & Identitas
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1">
              <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-wider">ID Anggota</span>
              <span class="text-[14px] font-semibold text-slate-700">#USR-<?= sprintf("%03d", $user['id']) ?></span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1">
              <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-wider">Email</span>
              <span class="text-[14px] font-semibold text-slate-700"><?= htmlspecialchars($user['email']) ?></span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1">
              <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Bergabung</span>
              <span class="text-[14px] font-semibold text-slate-700"><?= date('d F Y', strtotime($user['created_at'])) ?></span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1">
              <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-wider">Status Akses / Peran</span>
              <div class="flex items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> <?= $role_tampil ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="editMode" class="p-6 space-y-6 hidden bg-slate-50 border-t border-slate-200">
        <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-emerald-600"></i> Form Edit Profil
        </h2>
        
        <form id="formEditProfile" action="../../logic/user_process.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="action" value="update_profile">

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition text-sm" required>
                <span id="nameError" class="text-xs text-red-500 hidden mt-1">Nama tidak boleh kosong!</span>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition text-sm" required>
                <span id="emailError" class="text-xs text-red-500 hidden mt-1">Format email tidak valid!</span>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition text-sm">
                <span id="passwordError" class="text-xs text-red-500 hidden mt-1">Password minimal 6 karakter!</span>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="toggleEditMode(false)" class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-sm">Simpan</button>
            </div>
        </form>
      </div>

    </div>
  </div>

  <script>
    function toggleEditMode(isEditing) {
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');
        const btnEdit = document.getElementById('btnEditContainer');

        if(isEditing) {
            viewMode.classList.add('hidden');
            viewMode.classList.remove('block');
            editMode.classList.remove('hidden');
            editMode.classList.add('block');
            btnEdit.classList.add('hidden'); // Sembunyikan tombol edit saat form terbuka
        } else {
            viewMode.classList.remove('hidden');
            viewMode.classList.add('block');
            editMode.classList.add('hidden');
            editMode.classList.remove('block');
            btnEdit.classList.remove('hidden'); // Munculkan kembali tombol edit
        }
    }

    // Validasi Form 
    document.getElementById('formEditProfile').addEventListener('submit', function(e) {
        let valid = true;
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if(name === "") {
            document.getElementById('nameError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('nameError').classList.add('hidden');
        }

        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if(!email.match(emailPattern)) {
            document.getElementById('emailError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('emailError').classList.add('hidden');
        }

        if(password !== "" && password.length < 6) {
            document.getElementById('passwordError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('passwordError').classList.add('hidden');
        }

        if(!valid) e.preventDefault();
    });
  </script>
</body>
</html>