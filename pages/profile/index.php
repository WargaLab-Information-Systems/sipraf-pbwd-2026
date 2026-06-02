<?php
session_start();


// Jika belum login, kembalikan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Hubungkan ke database dan panggil fungsi user
require_once '../../helper/db_conn.php';
require_once '../../helper/data/user.php';

// Ambil data profil user ini dari database
$user = getUserById($conn, $_SESSION['user_id']);

// Tentukan nama jabatan pakai aturan IF biasa
if ($user['role'] == 'admin') {
    $role_tampil = 'Administrator';
} else if ($user['role'] == 'supervisor') {
    $role_tampil = 'Supervisor / PJ';
} else {
    $role_tampil = 'Pemohon';
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Saya – SIPRAF</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 flex min-h-screen">
<!-- SIDEBAR -->
<?php
$url = $_SERVER['PHP_SELF'];
$aktif = "bg-green-100 text-green-700 font-semibold";
$biasa = "hover:bg-gray-100 text-gray-600 transition";

if (!isset($conn)) require_once __DIR__ . '/../helper/db_conn.php';
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, foto FROM users WHERE id = '{$_SESSION['user_id']}'"));
?>

<aside class="w-72 bg-white border-r shadow-sm flex flex-col justify-between print:hidden">
    <div>
        <div class="p-8 border-b"><h1 class="text-4xl font-bold text-center text-black">SIPRAF</h1></div>
        
        <div class="p-6">
            <div class="mb-10">
                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">Dashboard</p>
                <a href="../dashboard/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl <?= strpos($url, 'dashboard') ? $aktif : $biasa ?>">
                    <i class="fa-solid fa-chart-line"></i><span class="font-medium">Dashboard</span>
                </a>
            </div>

            <div class="mb-10">
                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">Master Data</p>
                <div class="space-y-2">
                    <a href="../facilities/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl <?= strpos($url, 'facilities') ? $aktif : $biasa ?>">
                        <i class="fa-solid fa-building"></i><span class="font-medium">Facilities</span>
                    </a>
                    <a href="../users/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl <?= strpos($url, 'users') ? $aktif : $biasa ?>">
                        <i class="fa-solid fa-users"></i><span class="font-medium">Users</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">Feature</p>
                <div class="space-y-2">
                    <a href="../reservation/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl <?= strpos($url, 'reservation') ? $aktif : $biasa ?>">
                        <i class="fa-solid fa-calendar-check"></i><span class="font-medium">Peminjaman</span>
                    </a>
                    <a href="../approval/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl <?= strpos($url, 'approval') ? $aktif : $biasa ?>">
                        <i class="fa-solid fa-circle-check"></i><span class="font-medium">Persetujuan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 border-t <?= strpos($url, 'profile') ? 'bg-green-50 border-green-200' : '' ?>">
        <div class="flex items-center justify-between">
            <a href="../profile/index.php" class="flex items-center gap-3 hover:opacity-80 transition w-full">
                <?php if (!empty($user['foto'])): ?>
                    <img src="../../assets/img/<?= $user['foto'] ?>" class="w-12 h-12 rounded-full object-cover <?= strpos($url, 'profile') ? 'border-2 border-green-500' : '' ?>">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 <?= strpos($url, 'profile') ? 'border-2 border-green-500' : '' ?>"><i class="fa-solid fa-user"></i></div>
                <?php endif; ?>

                <div class="overflow-hidden">
                    <h2 class="font-semibold truncate w-32 <?= strpos($url, 'profile') ? 'text-green-800' : 'text-gray-700' ?>"><?= $user['name'] ?></h2>
                </div>
            </a>
            <button class="w-10 h-10 rounded-full bg-gray-200 hover:bg-red-500 hover:text-white transition flex-shrink-0"><i class="fa-solid fa-right-from-bracket"></i></button>
        </div>
    </div>
</aside>

<!-- SIDEBAR -->

  <main class="flex-1 py-10 px-8">
    <div class="max-w-4xl mx-auto space-y-6">
      
      <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

        <div class="p-6 relative pt-0 flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-100">
          <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-16 sm:-mt-12">
            
            <div class="w-24 h-24 bg-slate-200 rounded-2xl border-4 border-white shadow-md flex items-center justify-center text-slate-400 overflow-hidden">
              <?php if (!empty($user['foto'])) { ?>
                  <img src="../../assets/img/<?php echo htmlspecialchars($user['foto']); ?>" class="w-full h-full object-cover">
              <?php } else { ?>
                  <i class="fa-solid fa-user text-4xl"></i>
              <?php } ?>
            </div>
            
            <div class="text-center sm:text-left">
              <h1 class="text-2xl font-bold text-slate-800"><?php echo htmlspecialchars($user['name']); ?></h1>
              <p class="text-sm font-medium text-slate-500"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
          </div>
          
          <button id="btnEditContainer" onclick="bukaFormEdit()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-[13px] font-bold transition shadow-sm">
            <i class="fa-regular fa-pen-to-square"></i> Edit Profil
          </button>
        </div>

        <div id="viewMode" class="p-6 space-y-6 block">
          <h2 class="text-base font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-id-card text-emerald-600"></i> Informasi Akun & Identitas</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60"><span class="text-[10.5px] font-bold text-slate-400 uppercase block mb-1">ID Anggota</span><span class="text-sm font-semibold text-slate-700">#USR-<?php echo sprintf("%03d", $user['id']); ?></span></div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60"><span class="text-[10.5px] font-bold text-slate-400 uppercase block mb-1">Email</span><span class="text-sm font-semibold text-slate-700"><?php echo htmlspecialchars($user['email']); ?></span></div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60"><span class="text-[10.5px] font-bold text-slate-400 uppercase block mb-1">Status Akses / Peran</span><span class="text-sm font-semibold text-emerald-700"><?php echo $role_tampil; ?></span></div>
          </div>
        </div>

        <div id="editMode" class="p-6 space-y-6 hidden bg-slate-50 border-t border-slate-200">
          <h2 class="text-base font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-user-pen text-emerald-600"></i> Form Edit Profil</h2>
          
          <form id="formEditProfile" action="../../logic/user_process.php" method="POST" enctype="multipart/form-data" class="space-y-4">
              <input type="hidden" name="action" value="update_profile">
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                  <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 outline-none text-sm">
              </div>
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email *</label>
                  <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 outline-none text-sm">
              </div>

              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Foto Profil Baru (Opsional)</label>
                  <input type="file" id="foto" name="foto" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white outline-none text-sm">
                  <span class="text-xs text-slate-500 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto.</span>
              </div>
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Password Baru (Opsional)</label>
                  <input type="password" id="password" name="password" placeholder="Kosongkan jika tak diubah" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 outline-none text-sm">
              </div>
              
              <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                  <button type="button" onclick="tutupFormEdit()" class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-300">Batal</button>
                  <button type="submit" class="px-5 py-2 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700">Simpan</button>
              </div>
          </form>
        </div>

      </div>
    </div>
  </main>

  <script>
    function bukaFormEdit() {
        document.getElementById('viewMode').classList.add('hidden'); 
        document.getElementById('editMode').classList.remove('hidden'); 
        document.getElementById('btnEditContainer').classList.add('hidden'); 
    }
    function tutupFormEdit() {
        document.getElementById('viewMode').classList.remove('hidden'); 
        document.getElementById('editMode').classList.add('hidden'); 
        document.getElementById('btnEditContainer').classList.remove('hidden'); 
    }
  </script>

</body>
</html>