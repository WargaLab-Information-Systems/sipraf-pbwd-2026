<?php
require_once __DIR__ . '/../../helper/db_conn.php';
require_once __DIR__ . '/../../helper/data/facility.php';

// Siapkan variabel bawaan (kosong) untuk mode Tambah Data
$isEdit = false;
$facilityData = [
    'id' => '',
    'name' => '',
    'kategori' => '',
    'kapasitas' => '',
    'status' => 'tersedia',
    'deskripsi' => ''
];

if (isset($_GET['id'])) {
    $isEdit = true;
    $id = $_GET['id'];
    // Tarik data lama dari database berdasarkan ID
    $fetchedData = getFacilityById($conn, $id);

    if ($fetchedData) {
        $facilityData = $fetchedData;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit' : 'Tambah' ?> Fasilitas - SIPRAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden w-full max-w-xl">

        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            <div class="w-9 h-9 rounded-lg <?= $isEdit ? 'bg-green-50 text-green-700' : 'bg-emerald-50 text-emerald-700' ?> flex items-center justify-center text-xl flex-shrink-0">
                <i class="<?= $isEdit ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus' ?>"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800"><?= $isEdit ? 'Edit data fasilitas' : 'Tambah data fasilitas' ?></p>
                <p class="text-xs text-gray-400 mt-0.5">Isi semua field yang wajib diisi</p>
            </div>
        </div>

        <form id="facilityForm" action="../../logic/facility_process.php" method="POST" novalidate>

            <input type="hidden" name="action" value="<?= $isEdit ? 'update' : 'insert' ?>">
            <input type="hidden" name="status" value="<?= htmlspecialchars($facilityData['status']) ?>">

            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($facilityData['id']) ?>">
            <?php endif; ?>

            <div class="px-6 py-6 space-y-5">

                <div>
                    <label for="name" class="block text-xs font-medium text-gray-500 mb-1.5">
                        Nama fasilitas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                        value="<?= htmlspecialchars($facilityData['name']) ?>"
                        placeholder="Contoh: RKBF 204 atau Lab BIS"
                        class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <p id="error-name" class="hidden text-xs text-red-700 mt-1.5 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-sm"></i> Nama fasilitas tidak boleh kosong.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kategori" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" name="kategori"
                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 appearance-none">
                            <option value="">Pilih kategori</option>
                            <option value="lab" <?= $facilityData['kategori'] == 'lab' ? 'selected' : '' ?>>Laboratorium</option>
                            <option value="ruang" <?= $facilityData['kategori'] == 'ruang' ? 'selected' : '' ?>>Ruang kelas</option>
                            <option value="barang" <?= $facilityData['kategori'] == 'barang' ? 'selected' : '' ?>>Barang / peralatan</option>
                        </select>
                        <p id="error-kategori" class="hidden text-xs text-red-700 mt-1.5 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-sm"></i> Pilih kategori terlebih dahulu.
                        </p>
                    </div>
                    <div>
                        <label for="kapasitas" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Kapasitas <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="kapasitas" name="kapasitas" min="1"
                            value="<?= htmlspecialchars($facilityData['kapasitas']) ?>"
                            placeholder="Contoh: 40"
                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <p id="error-kapasitas" class="hidden text-xs text-red-700 mt-1.5 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-sm"></i> Minimal kapasitas adalah 1.
                        </p>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-medium text-gray-500 mb-1.5">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi detail fasilitas..."
                        class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 resize-none"><?= htmlspecialchars($facilityData['deskripsi']) ?></textarea>
                    <p id="error-deskripsi" class="hidden text-xs text-red-700 mt-1.5 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-sm"></i> Deskripsi tidak boleh kosong.
                    </p>
                </div>

            </div>

            <div id="loadingMessage" class="hidden px-6 pb-2">
                <div class="flex items-center gap-2 text-xs text-emerald-600">
                    <svg class="animate-spin w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Memproses data...
                </div>
            </div>
            <!-- button -->
            <div class="flex justify-end items-center gap-2 px-6 py-4 border-t border-gray-100">
                <button type="button" id="btnCancel"
                    class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" name="submit_facility"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium <?= $isEdit ? 'bg-green-600 hover:bg-green-700' : 'bg-emerald-600 hover:bg-emerald-700' ?> text-white rounded-lg transition">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $isEdit ? 'Update fasilitas' : 'Simpan fasilitas' ?>
                </button>
            </div>

        </form>
    </div>

    <script>
        const form = document.getElementById('facilityForm');

        function setError(id, show) {
            const input = document.getElementById(id);
            const error = document.getElementById('error-' + id);
            if (!input || !error) return;
            if (show) {
                input.classList.add('border-red-400', 'focus:ring-red-100', 'focus:border-red-400');
                input.classList.remove('focus:border-emerald-500', 'focus:ring-emerald-100');
                error.classList.remove('hidden');
            } else {
                input.classList.remove('border-red-400', 'focus:ring-red-100', 'focus:border-red-400');
                input.classList.add('focus:border-emerald-500', 'focus:ring-emerald-100');
                error.classList.add('hidden');
            }
        }

        ['name', 'kategori', 'kapasitas', 'deskripsi'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', () => setError(id, false));
        });

        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const kategori = document.getElementById('kategori').value;
            const kapasitas = document.getElementById('kapasitas').value;
            const deskripsi = document.getElementById('deskripsi').value.trim();
            let isValid = true;

            setError('name', !name);
            if (!name) isValid = false;
            setError('kategori', !['lab', 'ruang', 'barang'].includes(kategori));
            if (!['lab', 'ruang', 'barang'].includes(kategori)) isValid = false;
            const kap = parseInt(kapasitas);
            setError('kapasitas', !kapasitas || isNaN(kap) || kap < 1);
            if (!kapasitas || isNaN(kap) || kap < 1) isValid = false;
            setError('deskripsi', !deskripsi);
            if (!deskripsi) isValid = false;

            if (!isValid) {
                e.preventDefault();
            } else {
                const actionText = "<?= $isEdit ? 'diupdate' : 'disimpan' ?>";
                const konfirmasi = confirm(`Apakah data sudah benar dan ingin ${actionText}?`);

                if (!konfirmasi) {
                    e.preventDefault();
                } else {
                    document.getElementById('loadingMessage').classList.remove('hidden');
                }
            }
        });

        document.getElementById('btnCancel').addEventListener('click', function() {
            const konfirmasi = confirm("Apakah Anda yakin ingin membatalkan? Perubahan tidak akan disimpan.");
            if (konfirmasi) {
                window.location.href = 'index.php';
            }
        });
    </script>
</body>

</html>