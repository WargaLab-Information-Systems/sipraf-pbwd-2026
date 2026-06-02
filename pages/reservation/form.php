<?php
require '../../helper/db_conn.php';
require '../../helper/data/user.php';
require '../../helper/data/facility.php';

$users = getUsers($conn);
$facilities = getFacilities($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen m-0 p-0 overflow-hidden">

<div class="flex w-full h-screen">

    <!-- Sidebar -->
    <div class="w-64 flex-shrink-0 h-full">
        <div class="w-64 h-screen bg-white text-gray-700 flex flex-col justify-between border-r border-gray-200 font-sans">

            <div>
                <div class="p-6 border-b border-gray-100 flex items-center justify-center">
                    <h1 class="text-2xl font-bold tracking-wider text-gray-950">SIPRAF</h1>
                </div>

                <nav class="p-4 space-y-6">
                    <div>
                        <a href="../../pages/dashboard/index.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                            <i class="fa-solid fa-chart-pie text-lg text-gray-400 w-5 text-center"></i>
                            Dashboard
                        </a>
                    </div>

                    <div>
                        <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Master Data</span>
                        <div class="space-y-1">
                            <a href="../../pages/facilities/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                <i class="fa-solid fa-building text-lg text-gray-400 w-5 text-center"></i>
                                Facilities
                            </a>

                            <a href="../../pages/users/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                <i class="fa-solid fa-users text-lg text-gray-400 w-5 text-center"></i>
                                Users
                            </a>
                        </div>
                    </div>

                    <div>
                        <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Feature</span>
                        <div class="space-y-1">
                            <a href="../../pages/reservation/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-emerald-50 text-emerald-600 transition-colors text-sm font-semibold">
                                <i class="fa-solid fa-calendar-days text-lg text-emerald-500 w-5 text-center"></i>
                                Peminjaman
                            </a>

                            <a href="../../pages/approval/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-950 transition-colors text-sm font-medium">
                                <i class="fa-solid fa-circle-check text-lg text-gray-400 w-5 text-center"></i>
                                Persetujuan
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
                <a href="../../pages/profile/index.php" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-sm group-hover:bg-blue-500 transition-colors">
                        U
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors leading-tight">
                            Profile_name
                        </span>
                        <span class="text-xs text-gray-400">User</span>
                    </div>
                </a>

                <a href="../../logic/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Logout">
                    <i class="fa-solid fa-right-from-bracket text-base"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 h-full overflow-y-auto p-6">

        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 border border-gray-200">

            <div class="border-b border-gray-200 pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    FORM PENGAJUAN PEMINJAMAN
                </h1>
                <p class="text-sm text-gray-500">
                    Sistem Informasi Peminjaman Fasilitas (SIPRAF)
                </p>
            </div>

            <form action="../../logic/reservation_process.php" method="POST" id="reservationForm" class="space-y-5">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pilih User
                    </label>
                    <select name="user_id" id="user_id" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                        <option value="">-- Pilih User --</option>
                        <?php while($user = mysqli_fetch_assoc($users)) { ?>
                            <option value="<?= $user['id']; ?>">
                                <?= htmlspecialchars($user['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <p id="errorUser" class="error-message hidden text-red-500 text-xs mt-1">User wajib dipilih.</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pilih Fasilitas
                    </label>
                    <select name="facility_id" id="facility_id" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                        <option value="">-- Pilih Fasilitas --</option>
                        <?php while($facility = mysqli_fetch_assoc($facilities)) { ?>
                            <option value="<?= $facility['id']; ?>">
                                <?= htmlspecialchars($facility['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <p id="errorFacility" class="error-message hidden text-red-500 text-xs mt-1">Fasilitas wajib dipilih.</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Tanggal
                    </label>
                    <input type="date" name="tanggal" id="tanggal" min="<?= date('Y-m-d'); ?>" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                    <p id="errorTanggal" class="error-message hidden text-red-500 text-xs mt-1">Tanggal wajib diisi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Jam Mulai
                        </label>
                        <input type="time" name="jam_mulai" id="jam_mulai" min="07:00" max="21:00" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                        <p id="errorMulai" class="error-message hidden text-red-500 text-xs mt-1">Jam mulai wajib diisi.</p>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            Jam Selesai
                        </label>
                        <input type="time" name="jam_selesai" id="jam_selesai" min="07:00" max="21:00" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                        <p id="errorSelesai" class="error-message hidden text-red-500 text-xs mt-1">Jam selesai wajib diisi dan harus lebih besar dari jam mulai.</p>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Keperluan
                    </label>
                    <textarea name="notes" id="notes" rows="5" class="input-field w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition resize-none" placeholder="Tuliskan keperluan peminjaman..."></textarea>
                    <p id="errorNotes" class="error-message hidden text-red-500 text-xs mt-1">Keperluan wajib diisi.</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button  type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded shadow text-sm font-semibold transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        Ajukan Peminjaman
                    </button>

                    <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded shadow text-sm font-semibold transition-colors">
                        Lihat Data
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
const form = document.getElementById('reservationForm');

function setInvalid(input, error) {
    input.classList.remove('border-gray-300', 'border-emerald-500');
    input.classList.add('border-red-500', 'focus:ring-red-400', 'focus:border-red-400');
    error.classList.remove('hidden');
}

function setValid(input, error) {
    input.classList.remove('border-red-500', 'focus:ring-red-400', 'focus:border-red-400');
    input.classList.add('border-emerald-500');
    error.classList.add('hidden');
}

function validateForm() {
    let valid = true;

    const user = document.getElementById('user_id');
    const facility = document.getElementById('facility_id');
    const tanggal = document.getElementById('tanggal');
    const mulai = document.getElementById('jam_mulai');
    const selesai = document.getElementById('jam_selesai');
    const notes = document.getElementById('notes');

    if (!user.value) {
        setInvalid(user, document.getElementById('errorUser'));
        valid = false;
    } else {
        setValid(user, document.getElementById('errorUser'));
    }

    if (!facility.value) {
        setInvalid(facility, document.getElementById('errorFacility'));
        valid = false;
    } else {
        setValid(facility, document.getElementById('errorFacility'));
    }

    if (!tanggal.value) {
        setInvalid(tanggal, document.getElementById('errorTanggal'));
        valid = false;
    } else {
        setValid(tanggal, document.getElementById('errorTanggal'));
    }

    if (!mulai.value) {
        setInvalid(mulai, document.getElementById('errorMulai'));
        valid = false;
    } else {
        setValid(mulai, document.getElementById('errorMulai'));
    }

    if (!selesai.value || (mulai.value && selesai.value && mulai.value >= selesai.value)) {
        setInvalid(selesai, document.getElementById('errorSelesai'));
        valid = false;
    } else {
        setValid(selesai, document.getElementById('errorSelesai'));
    }

    if (!notes.value.trim()) {
        setInvalid(notes, document.getElementById('errorNotes'));
        valid = false;
    } else {
        setValid(notes, document.getElementById('errorNotes'));
    }

    return valid;
}

form.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
    }
});

document.querySelectorAll('.input-field').forEach(function(input) {
    input.addEventListener('input', validateForm);
    input.addEventListener('change', validateForm);
});
</script>

</body>
</html>