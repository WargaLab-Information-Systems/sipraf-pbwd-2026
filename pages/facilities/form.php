<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Formulir Fasilitas</title>

  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">

  <div class="flex justify-between items-center mb-8">

    <h1 class="text-3xl font-bold">
      Form Peminjaman Ruangan
    </h1>

    <a href="index.php"
    class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">

      Kembali

    </a>

  </div>

  <form class="space-y-6">

    <div>

      <label class="block mb-2 font-semibold">
        Nama Peminjam
      </label>

      <input type="text"
      placeholder="Masukkan nama mahasiswa"
      class="w-full border rounded-xl px-4 py-3">

    </div>

    <div>

      <label class="block mb-2 font-semibold">
        Email Peminjam
      </label>

      <input type="text"
      placeholder="Masukkan Email"
      class="w-full border rounded-xl px-4 py-3">

    </div>

    <div>

      <label class="block mb-2 font-semibold">
        Pilih Pinjaman
      </label>

      <select class="w-full border rounded-xl px-4 py-3">

        <option>Lab TI</option>
        <option>Lab BIS</option>
        <option>RKBF 204</option>
        <option>RKBF 307</option>
        <option>RKBF 308</option>
        <option>RKBF 407</option>
        <option>RKBF 408</option>
        <option>Proyektor 01</option>
        <option>Proyektor 02</option>
        <option>Switch 01</option>
        <option>Switch 02</option>
        <option>Router 01</option>
        <option>Router 02</option>

      </select>

    </div>

    <div>

      <label class="block mb-2 font-semibold">
        Tanggal Peminjaman
      </label>

      <input type="date"
      class="w-full border rounded-xl px-4 py-3">

    </div>

    <div>

      <label class="block mb-2 font-semibold">
        Fasilitas Tambahan (Jika Memilih Ruangan)
      </label>

      <div class="grid grid-cols-2 gap-4">

        <label class="flex items-center gap-2">
          <input type="checkbox">
          Proyektor
        </label>

        <label class="flex items-center gap-2">
          <input type="checkbox">
          WiFi
        </label>

        <label class="flex items-center gap-2">
          <input type="checkbox">
          Komputer
        </label>

        <label class="flex items-center gap-2">
          <input type="checkbox">
          Sound System
        </label>

        <label class="flex items-center gap-2">
          <input type="checkbox">
          Tidak Ada (Hanya Meminjam Fasilitas)
        </label>
      </div>

    </div>

    <div>

      <label class="block mb-2 font-semibold">
        Keperluan
      </label>

      <textarea rows="5"
      placeholder="Masukkan keperluan"
      class="w-full border rounded-xl px-4 py-3"></textarea>

    </div>

    <button
    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

      Simpan Data

    </button>

  </form>

</div>

</body>
</html>