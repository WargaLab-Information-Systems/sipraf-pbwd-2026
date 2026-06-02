<?php
require '../../helper/db_conn.php';

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "
    SELECT
        r.*,
        u.name AS peminjam,
        u.email,
        f.name AS fasilitas,
        f.kategori,
        f.kapasitas,
        f.deskripsi
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN facilities f ON r.facility_id = f.id
    WHERE r.id='$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservation - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800 font-sans flex min-h-screen">

    <body class="bg-gray-100">

        <div class="flex min-h-screen">


            <!-- SIDEBAR -->
            <?php include '../../includes/sidebar.php' ?>

        </div>


        <!-- CONTENT -->
        <main class="flex-1 p-8">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Detail Reservation
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Informasi lengkap peminjaman fasilitas
                    </p>
                </div>

                <?php
                if ($data['status'] == 'disetujui') {
                    echo "<span class='bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium'>✅ Disetujui</span>";
                } elseif ($data['status'] == 'ditolak') {
                    echo "<span class='bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium'>❌ Ditolak</span>";
                } else {
                    echo "<span class='bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium'>⏳ Diajukan</span>";
                }
                ?>
            </div>


            <!-- DETAIL GRID -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Peminjam -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        👤 Data Peminjam
                    </h2>

                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-500">Nama</span><br>
                            <span class="font-medium"><?= $data['peminjam'] ?></span>
                        </p>

                        <p>
                            <span class="text-gray-500">Email</span><br>
                            <span class="font-medium"><?= $data['email'] ?></span>
                        </p>
                    </div>
                </div>


                <!-- Fasilitas -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        🏢 Data Fasilitas
                    </h2>

                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-500">Fasilitas</span><br>
                            <span class="font-medium"><?= $data['fasilitas'] ?></span>
                        </p>

                        <p>
                            <span class="text-gray-500">Kategori</span><br>
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                <?= ucfirst($data['kategori']) ?>
                            </span>
                        </p>

                        <p>
                            <span class="text-gray-500">Kapasitas</span><br>
                            <span class="font-medium">
                                <?= $data['kapasitas'] ?> Orang
                            </span>
                        </p>
                    </div>
                </div>


                <!-- Jadwal -->
                <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        📅 Jadwal Reservasi
                    </h2>

                    <div class="grid md:grid-cols-2 gap-4">

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-gray-500 text-sm">Tanggal</p>
                            <p class="font-semibold text-lg">
                                <?= date('d F Y', strtotime($data['tanggal'])) ?>
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-gray-500 text-sm">Jam</p>
                            <p class="font-semibold text-lg">
                                <?= substr($data['jam_mulai'], 0, 5) ?>
                                -
                                <?= substr($data['jam_selesai'], 0, 5) ?>
                            </p>
                        </div>

                    </div>
                </div>


                <!-- Catatan -->
                <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">
                        📝 Catatan Peminjam
                    </h2>

                    <div class="bg-gray-50 border rounded-xl p-4 text-gray-700">
                        <?= $data['notes'] ?: 'Tidak ada catatan.' ?>
                    </div>


                    <!-- Deskripsi -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6 md:col-span-2">
                        <h2 class="font-semibold text-lg text-gray-700 mb-4">
                            📄 Deskripsi Fasilitas
                        </h2>

                        <div class="bg-gray-50 border rounded-xl p-4 text-gray-700">
                            <?= $data['deskripsi'] ?: 'Tidak ada deskripsi.' ?>
                        </div>
                    </div>

                </div>


                <!-- ACTION -->
                <div class="flex gap-3 mt-6">

                    <a href="index.php"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-xl transition shadow-sm">
                        ← Kembali
                    </a>

                </div>

        </main>
        </div>

    </body>

</body>

</html>