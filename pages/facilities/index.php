<?php
// Memulai session 
session_start();

// Memanggil koneksi database sesuai struktur folder Anda
require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/facility.php';

// Membaca data fasilitas yang statusnya khusus 'dipinjam'
$query = mysqli_query($conn, "SELECT * FROM facilities WHERE LOWER(status) = 'dipinjam'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAF - FASILITAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-50 flex min-h-screen">
  
    <!-- Sidebar -->
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>


  <main class="flex-1 p-8 print:p-0">
    
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-gray-950 tracking-tight">Fasilitas Sedang Dipinjam</h2>
        <p class="text-sm text-gray-500 mt-1">Menampilkan log data seluruh ruangan atau barang kampus yang saat ini tidak tersedia.</p>
      </div>
      <button onclick="window.print()" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition print:hidden">
        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
      </button>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden print:border-0 print:shadow-none">
      <table class="w-full text-left border-collapse text-sm text-gray-600">
        <thead class="bg-gray-50 text-gray-700 font-semibold border-b border-gray-200">
          <tr>
            <th class="p-4 w-16 text-center">No</th>
            <th class="p-4">Nama Fasilitas / Ruangan</th>
            <th class="p-4">Kategori</th>
            <th class="p-4">Kapasitas</th>
            <th class="p-4 text-center">Status</th>
            <th class="p-4 text-center print:hidden">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php 
          $no = 1;
          if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
              $kategori_clean = strtolower($row['kategori']);
              if (strpos($kategori_clean, 'ruang') !== false || strpos($kategori_clean, 'kelas') !== false) {
                  $kat_label = 'Ruang Kelas'; $kat_bg = 'bg-blue-100 text-blue-600'; $unit = ' Orang';
              } elseif (strpos($kategori_clean, 'lab') !== false || strpos($kategori_clean, 'laboratorium') !== false) {
                  $kat_label = 'Laboratorium'; $kat_bg = 'bg-purple-100 text-purple-600'; $unit = ' Orang';
              } else {
                  $kat_label = 'Barang'; $kat_bg = 'bg-orange-100 text-orange-600'; $unit = ' Unit';
              }
          ?>
          <tr class="hover:bg-gray-50/50 transition">
            <td class="p-4 text-center font-medium text-gray-400"><?php echo $no++; ?></td>
            <td class="p-4 font-semibold text-gray-900"><?php echo $row['name']; ?></td>
            <td class="p-4">
              <span class="px-2.5 py-1 rounded-md text-xs font-bold <?php echo $kat_bg; ?>">
                <?php echo $kat_label; ?>
              </span>
            </td>
            <td class="p-4 font-medium text-gray-700"><?php echo $row['kapasitas'] . $unit; ?></td>
            <td class="p-4 text-center">
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dipinjam
              </span>
            </td>
            <td class="p-4 text-center print:hidden">
              <a href="detail.php?id=<?php echo $row['id']; ?>" class="inline-flex text-xs bg-gray-100 hover:bg-green-700 hover:text-white text-gray-700 font-semibold px-3 py-1.5 rounded-lg transition">
                Lihat Detail
              </a>
            </td>
          </tr>
          <?php 
            }
          } else {
          ?>
          <tr>
            <td colspan="6" class="p-12 text-center text-gray-400 font-medium">
              📭 Saat ini tidak ada fasilitas atau ruangan yang sedang dipinjam.
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </main>

</body>
</html>