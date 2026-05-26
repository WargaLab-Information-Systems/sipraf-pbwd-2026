<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard SIM Ruang</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

  <aside class="w-72 bg-white shadow-xl p-6">

    <h1 class="text-3xl font-bold text-green-700 mb-10">
      SIPRAF
    </h1>

    <nav class="space-y-3">

      <a href="index.php"
      class="flex items-center gap-3 p-4 rounded-xl bg-green-100 text-green-700 font-semibold">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
      </a>

      <a href="form.php"
      class="flex items-center gap-3 p-4 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-plus"></i>
        Tambah Fasilitas
      </a>

      <a href="detail.php"
      class="flex items-center gap-3 p-4 rounded-xl hover:bg-gray-100">
        <i class="fa-solid fa-file-lines"></i>
        Detail Fasilitas
      </a>

    </nav>

  </aside>

  <main class="flex-1 p-8">

    <div class="flex justify-between items-center mb-8">

      <div>

        <h1 class="text-4xl font-bold text-gray-800">
          Facility Management
        </h1>

        <p class="text-gray-500 mt-2">
          Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus
        </p>

      <a href="form.php"
      class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl">
        + Add
      </a>
    </div>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Total Rooms</p>
        <h2 class="text-3xl font-bold mt-2">120</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Visitors</p>
        <h2 class="text-3xl font-bold mt-2">542</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Bookings</p>
        <h2 class="text-3xl font-bold mt-2">85</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Revenue</p>
        <h2 class="text-3xl font-bold mt-2">$12K</h2>
>>>>>>> 8fb0e57 (modified)
      </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Total Ruangan</p>
        <h2 class="text-4xl font-bold mt-2">7</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Reservasi</p>
        <h2 class="text-4xl font-bold mt-2">30</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">User</p>
        <h2 class="text-4xl font-bold mt-2">11</h2>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Fasilitas</p>
        <h2 class="text-4xl font-bold mt-2">6</h2>
      </div>

    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">

      <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
          Data Fasilitas Kampus
        </h2>

        <input type="text"
        placeholder="Cari data..."
        class="border px-4 py-2 rounded-xl">

      </div>

      <table class="w-full text-left">

        <thead>

          <tr class="border-b text-gray-600">

            <th class="pb-4">Nama</th>
            <th class="pb-4">Kategori</th>
            <th class="pb-4">Kapasitas</th>
            <th class="pb-4">Status</th>
            <th class="pb-4">Aksi</th>

          </tr>

        </thead>

        <tbody class="text-gray-700">

          <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Lab TI
            </td>
            <td>
              Laboratorium Teknologi Informasi
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tr class="border-b hover:bg-gray-50">

            <td class="py-4 font-semibold">
              Lab BIS
            </td>
            <td>
              Laboratorium Bisnis dan Sistem Informasi
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tbody class="text-gray-700">

          <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              RKBF 204            </td>
            <td>
              Ruang Kelas Lantai 2 Gedung B Fakultas
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tbody class="text-gray-700">

          <tr class="border-b hover:bg-gray-50">

            <td class="py-4 font-semibold">
              RKBF 307
            </td>
            <td>
              Ruang Kelas Lantai 3 Gedung B Fakultas
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>
          <tbody class="text-gray-700">

          <tr class="border-b hover:bg-gray-50">

            <td class="py-4 font-semibold">
              RKBF 308
            </td>
            <td>
              Ruang Kelas Lantai 3 Gedung B Fakultas
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

                    <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              RKBF 407
            </td>
            <td>
              Ruang Kelas Lantai 4 Gedung B Fakultas
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

                    <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              RKBF 408
            </td>
            <td>
              Ruang Kelas Lantai 4 Gedung B Fakultas
            </td>
            <td>
              40 Orang
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

                    <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Proyektor 01
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

                    <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Proyektor 02
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

                    <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Switch 01
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Switch 02
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Router 01
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

          <tr class="border-b hover:bg-gray-50">
            <td class="py-4 font-semibold">
              Router 01
            </td>
            <td>
              Barang
            </td>
            <td>
              1
            </td>
            <td>
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                Tersedia
              </span>
            </td>
            <td>
              <a href="detail.php"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Detail
              </a>
            </td>
          </tr>

        </tbody>

      </table>

    </div>

  </main>

</div>

</body>
</html>