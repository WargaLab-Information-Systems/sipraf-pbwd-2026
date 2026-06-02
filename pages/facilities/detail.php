<?php
// 1. Panggil koneksi database sesuai struktur folder Anda
require_once __DIR__ . '/../../helper/db_conn.php';

// 2. Pengaman 1: Cek apakah ada ID di URL (misal: detail.php?id=1)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Akses ditolak! ID Fasilitas tidak ditemukan.'); window.location.href='index.php';</script>";
    exit;
}

// 3. Amankan ID dari URL agar terhindar dari error/hack
$id_fasilitas = mysqli_real_escape_string($conn, $_GET['id']);

// 4. Cari data fasilitas di database berdasarkan ID tersebut
$query = mysqli_query($conn, "SELECT * FROM facilities WHERE id = '$id_fasilitas'");

// 5. Pengaman 2: Cek apakah datanya benar-benar ada di database
if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Data fasilitas tidak ditemukan di database!'); window.location.href='index.php';</script>";
    exit;
}

// 6. Ubah hasil pencarian menjadi array agar mudah ditampilkan
$fasilitas = mysqli_fetch_assoc($query);

// 7. Siapkan variabel untuk Kategori agar tampilannya rapi
if ($fasilitas['kategori'] == 'barang') {
    $nama_kategori = 'Barang / Perangkat';
    $satuan = ' Unit';
    $ikon = 'fa-box';
} else {
    // Jika bukan barang, berarti Ruang atau Lab
    $nama_kategori = 'Ruangan / Lab';
    $satuan = ' Orang';
    $ikon = 'fa-building';
}

// 8. Siapkan variabel untuk Status (Warna dan Teks)
if ($fasilitas['status'] == 'tersedia') {
    $teks_status = 'Tersedia';
    $warna_status = 'bg-green-100 text-green-700 border-green-200';
} else {
    $teks_status = 'Sedang Dipinjam';
    $warna_status = 'bg-red-100 text-red-700 border-red-200';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Fasilitas - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <?php include '../../includes/sidebar.php' ?>

    <main class="flex-1 p-8">
        
        <div class="flex justify-between items-center mb-10 print:hidden">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Detail Informasi Fasilitas</h1>
                <p class="text-gray-500 mt-2">Melihat rincian lengkap mengenai ruangan atau perangkat.</p>
            </div>
            <div>
                <a href="index.php" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl border border-gray-200">
            
            <div class="flex items-center gap-4 mb-8 border-b pb-6">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-2xl">
                    <i class="fa-solid <?php echo $ikon; ?>"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($fasilitas['name']); ?></h2>
                    <p class="text-gray-500 font-semibold mt-1">ID Data: #<?php echo $fasilitas['id']; ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">Kategori</p>
                    <p class="text-lg text-gray-800 bg-gray-50 px-4 py-2 rounded-lg border"><?php echo $nama_kategori; ?></p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">Kapasitas / Jumlah</p>
                    <p class="text-lg text-gray-800 bg-gray-50 px-4 py-2 rounded-lg border"><?php echo htmlspecialchars($fasilitas['kapasitas']) . $satuan; ?></p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">Status Saat Ini</p>
                    <span class="inline-flex px-4 py-2 rounded-lg font-bold border <?php echo $warna_status; ?>">
                        <?php echo $teks_status; ?>
                    </span>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">Didaftarkan Pada</p>
                    <p class="text-lg text-gray-800 bg-gray-50 px-4 py-2 rounded-lg border"><?php echo $fasilitas['created_at']; ?></p>
                </div>

                <div class="col-span-2">
                    <p class="text-sm text-gray-500 font-bold mb-1">Deskripsi Lengkap</p>
                    <div class="text-gray-700 bg-gray-50 px-5 py-4 rounded-lg border min-h-[100px]">
                        <?php 
                            if (empty($fasilitas['deskripsi'])) {
                                echo "<span class='text-gray-400 italic'>Tidak ada catatan deskripsi.</span>";
                            } else {
                                echo nl2br(htmlspecialchars($fasilitas['deskripsi']));
                            }
                        ?>
                    </div>
                </div>

            </div>

        </div>

    </main>
</div>

</body>
</html>