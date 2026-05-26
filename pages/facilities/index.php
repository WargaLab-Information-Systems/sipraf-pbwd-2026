<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard Kampus</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans">

<div class="flex">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white min-h-screen shadow-lg p-6">

    <h1 class="text-2xl font-bold text-green-700 mb-10">
      SIM Ruang
    </h1>

    <nav class="space-y-4">

      <a href="index.php"
      class="flex items-center gap-3 p-3 rounded-xl bg-green-100 text-green-700 font-semibold">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
      </a>

      <a href="form.php"
      class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-plus"></i>
        Peminjaman
      </a>

      <a href="detail.php"
      class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-file-lines"></i>
        Detail
      </a>

      <a href="#"
      class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-building"></i>
        Ruangan
      </a>

      <a href="#"
      class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-users"></i>
        Mahasiswa
      </a>

    </nav>

  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

      <div>
        <h1 class="text-3xl font-bold text-gray-800">
          Dashboard
        </h1>

        <p class="text-gray-500">
          Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus
        </p>
      </div>

      <a href="form.php"
      class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl">
        + Tambah Peminjaman
      </a>

    </div>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Total Ruangan</p>
        <h2 class="text-3xl font-bold mt-2">25</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Peminjaman Aktif</p>
        <h2 class="text-3xl font-bold mt-2">18</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Mahasiswa</p>
        <h2 class="text-3xl font-bold mt-2">240</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Fasilitas</p>
        <h2 class="text-3xl font-bold mt-2">52</h2>
      </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow p-6">

      <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
          Data Peminjaman
        </h2>

        <a href="detail.php"
        class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg">
          Lihat Detail
        </a>

      </div>

      <div class="overflow-x-auto">

        <table class="w-full text-left">

          <thead>
            <tr class="border-b">
              <th class="pb-4">Nama</th>
              <th class="pb-4">Ruangan</th>
              <th class="pb-4">Tanggal</th>
              <th class="pb-4">Status</th>
            </tr>
          </thead>

          <tbody>

            <tr class="border-b hover:bg-gray-50">
              <td class="py-4">Andi Saputra</td>
              <td>Lab Komputer 1</td>
              <td>12 Mei 2026</td>
              <td>
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                  Disetujui
                </span>
              </td>
            </tr>

            <tr class="border-b hover:bg-gray-50">
              <td class="py-4">Siti Rahma</td>
              <td>Ruang Seminar</td>
              <td>14 Mei 2026</td>
              <td>
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                  Pending
                </span>
              </td>
            </tr>

            <tr class="hover:bg-gray-50">
              <td class="py-4">Budi Santoso</td>
              <td>Aula Kampus</td>
              <td>15 Mei 2026</td>
              <td>
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                  Ditolak
                </span>
              </td>
            </tr>

          </tbody>

        </table>

      </div>

    </div>

  </main>

</div>

</body>
</html>                             