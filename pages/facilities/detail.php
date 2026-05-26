<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Detail Peminjaman</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-5xl mx-auto mt-10">

  <div class="bg-white p-8 rounded-2xl shadow">

    <div class="flex justify-between items-center mb-8">

      <h1 class="text-3xl font-bold">
        Detail Peminjaman
      </h1>

      <a href="index.php"
      class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
        Kembali
      </a>

    </div>

    <!-- DETAIL -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          Nama Mahasiswa
        </p>

        <h2 class="text-2xl font-bold">
          Andi Saputra
        </h2>
      </div>

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          NIM
        </p>

        <h2 class="text-2xl font-bold">
          231011401
        </h2>
      </div>

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          Ruangan
        </p>

        <h2 class="text-2xl font-bold">
          Lab Komputer 1
        </h2>
      </div>

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          Status
        </p>

        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">
          Disetujui
        </span>
      </div>

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          Tanggal Peminjaman
        </p>

        <h2 class="text-2xl font-bold">
          12 Mei 2026
        </h2>
      </div>

      <div class="bg-gray-50 p-6 rounded-2xl">
        <p class="text-gray-500 mb-2">
          Fasilitas
        </p>

        <h2 class="text-xl font-semibold">
          Proyektor, AC, WiFi
        </h2>
      </div>

    </div>

    <!-- KEPERLUAN -->
    <div class="mt-8 bg-gray-50 p-6 rounded-2xl">

      <h2 class="text-2xl font-bold mb-4">
        Keperluan
      </h2>

      <p class="text-gray-600 leading-relaxed">
        Digunakan untuk kegiatan presentasi seminar proposal
        dan diskusi kelompok mahasiswa teknik informatika.
      </p>

    </div>

  </div>

</div>

</body>
</html>