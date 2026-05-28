<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form User Management</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 font-sans">

<div class="max-w-3xl mx-auto py-10">

    <div class="bg-white rounded-3xl shadow-lg p-10">

        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            Form User
        </h1>

        <p class="text-gray-500 mb-8">
            Tambah Data User Sistem
        </p>

        <form id="userForm" class="space-y-6">

            <div>

                <label class="block mb-2 font-semibold">
                    Nama Lengkap
                </label>

                <input type="text"
                placeholder="Masukkan nama"
                class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                placeholder="Masukkan email"
                class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Password
                </label>

                <input type="password"
                placeholder="Masukkan password"
                class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Role
                </label>

                <select class="w-full border rounded-xl px-4 py-3">

                    <option>Admin</option>
                    <option>Supervisor</option>
                    <option>Borrower</option>
                </select>

            </div>

            <div class="flex gap-4">

                <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                    Simpan

                </button>

                <a href="index.html"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

<!-- JS -->
<script>

document.getElementById("userForm").addEventListener("submit", function(e){

    e.preventDefault();

    alert("Data user berhasil disimpan!");

});

</script>

</body>
</html>