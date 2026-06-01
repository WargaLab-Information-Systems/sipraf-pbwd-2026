<?php
session_start();

// Proteksi Halaman: Jika belum login, kembalikan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// 1. Panggil koneksi ke database & helper user
require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/user.php';


// Ambil data user yang sedang login untuk kebutuhan komponen Sidebar
$user_id = $_SESSION['user_id'];
$user = getUserById($conn, $user_id);
$inisial = strtoupper(substr($user['name'], 0, 1));

// 2. Ambil ID dari URL (contoh: detail.php?id=5)
$id_fasilitas = 0;
if (isset($_GET['id'])) {
    // Menambahkan keamanan real_escape_string untuk mencegah SQL Injection
    $id_fasilitas = mysqli_real_escape_string($conn, $_GET['id']);
}

// 3. Cari data ruangan/fasilitas di database
$query_ruangan = mysqli_query($conn, "SELECT * FROM facilities WHERE id = '$id_fasilitas'");
$data_ruangan = mysqli_fetch_assoc($query_ruangan);

// Jika ruangan tidak ada di database, hentikan halaman
if (!$data_ruangan) {
    die("<script>alert('Fasilitas tidak ditemukan!'); window.location.href='index.php';</script>");
}

// 4. Jika ruangan sedang dipinjam, cari tahu siapa yang pinjam!
$data_pinjam = null; // Bikin wadah kosong dulu
if (strtolower($data_ruangan['status']) == 'dipinjam') {
    
    // PERBAIKAN: Mengubah users.nama menjadi users.name agar sinkron dengan struktur database Anda
    $query_pinjam = mysqli_query($conn, "
        SELECT reservation.*, users.name AS nama_peminjam
        FROM reservation 
        JOIN users ON reservation.user_id = users.id
        WHERE reservation.facility_id = '$id_fasilitas'
        ORDER BY reservation.id DESC LIMIT 1
    ");
    
    // Masukkan datanya ke wadah tadi
    $data_pinjam = mysqli_fetch_assoc($query_pinjam);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Fasilitas - SIPRAF</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

  <main class="flex-1 p-8">
    <div class="mb-4">
      <a href="index.php" class="text-sm text-gray-500 hover:text-green-700 font-medium">← Kembali ke Daftar</a>
    </div>

    <div class="max-w-3xl bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        
        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($data_ruangan['name']); ?></h3>
        <p class="text-sm text-gray-500 mb-4">Kapasitas: <?php echo htmlspecialchars($data_ruangan['kapasitas']); ?></p>

        <?php if ($data_pinjam != null) { ?>
            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-4">
                <h4 class="text-xs font-bold uppercase text-red-600 mb-3">Info Peminjaman Saat Ini</h4>
                <p class="text-sm"><strong>Peminjam:</strong> <?php echo htmlspecialchars($data_pinjam['nama_peminjam']); ?></p>
                <p class="text-sm"><strong>Tanggal:</strong> <?php echo htmlspecialchars($data_pinjam['tanggal_pinjam']); ?></p>
                <p class="text-sm"><strong>Waktu:</strong> <?php echo htmlspecialchars($data_pinjam['jam_mulai']); ?> s/d <?php echo htmlspecialchars($data_pinjam['jam_selesai']); ?></p>
                <p class="text-sm"><strong>Tujuan:</strong> <?php echo htmlspecialchars($data_pinjam['tujuan']); ?></p>
            </div>
        <?php } ?>

        <div class="border-t border-gray-100 pt-4 mb-4">
            <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Deskripsi Fasilitas</h4>
            <p class="text-sm text-gray-600"><?php echo nl2br(htmlspecialchars($data_ruangan['deskripsi'])); ?></p>
        </div>

        <div class="border-t border-gray-100 pt-4">
            <?php if (strtolower($data_ruangan['status']) == 'tersedia') { ?>
                <a href="form.php?facility_id=<?php echo $data_ruangan['id']; ?>" class="block text-center w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 rounded-xl transition">Ajukan Peminjaman</a>
            <?php } else { ?>
                <button disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-3 rounded-xl cursor-not-allowed">❌ Fasilitas Sedang Dipinjam</button>
            <?php } ?>
        </div>

    </div>
  </main>

</body>
</html>