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

// Ambil huruf pertama nama untuk inisial foto profil
$inisial = strtoupper(substr($user['name'], 0, 1));
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
<body class="bg-slate-100 text-slate-800 flex min-h-screen">

    <!-- Sidebar -->
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

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
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60"><span class="text-[10.5px] font-bold text-slate-400 uppercase block mb-1">Tanggal Bergabung</span><span class="text-sm font-semibold text-slate-700"><?php echo date('d F Y', strtotime($user['created_at'])); ?></span></div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
              <span class="text-[10.5px] font-bold text-slate-400 uppercase block mb-1">Status Akses / Peran</span>
              <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> <?php echo $role_tampil; ?></span>
            </div>
          </div>
        </div>

        <div id="editMode" class="p-6 space-y-6 hidden bg-slate-50 border-t border-slate-200">
          <h2 class="text-base font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-user-pen text-emerald-600"></i> Form Edit Profil</h2>
          
          <form id="formEditProfile" action="../../logic/user_process.php" method="POST" class="space-y-4">
              <input type="hidden" name="action" value="update_profile">
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                  <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 outline-none text-sm">
                  <span id="nameError" class="text-xs text-red-500 hidden mt-1">Nama wajib diisi!</span>
              </div>
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email *</label>
                  <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 outline-none text-sm">
                  <span id="emailError" class="text-xs text-red-500 hidden mt-1">Email wajib diisi dan harus ada tanda @</span>
              </div>
              
              <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Password Baru (Opsional)</label>
                  <input type="password" id="password" name="password" placeholder="Kosongkan jika tak diubah" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 outline-none text-sm">
                  <span id="passwordError" class="text-xs text-red-500 hidden mt-1">Password minimal 6 karakter!</span>
              </div>
              
              <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                  <button type="button" onclick="tutupFormEdit()" class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50">Batal</button>
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

    document.getElementById('formEditProfile').addEventListener('submit', function(event) {
        let berhasil = true; 
        
        let nama_input = document.getElementById('name').value;
        let email_input = document.getElementById('email').value;
        let pass_input = document.getElementById('password').value;

        if (nama_input === "") {
            document.getElementById('nameError').classList.remove('hidden');
            berhasil = false; 
        } else {
            document.getElementById('nameError').classList.add('hidden');
        }

        if (email_input === "" || email_input.includes("@") === false) {
            document.getElementById('emailError').classList.remove('hidden');
            berhasil = false; 
        } else {
            document.getElementById('emailError').classList.add('hidden');
        }

        if (pass_input !== "" && pass_input.length < 6) {
            document.getElementById('passwordError').classList.remove('hidden');
            berhasil = false; 
        } else {
            document.getElementById('passwordError').classList.add('hidden');
        }

        if (berhasil === false) {
            event.preventDefault();
        }
    });
  </script>

</body>
</html>