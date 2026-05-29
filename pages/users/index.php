<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans">

<div class="max-w-7xl mx-auto py-10">

    <!-- HEADER -->
    <div class="flex justify-between items-start mb-10">

        <div>

            <h1 class="text-4xl font-bold text-gray-800">
                User Management
            </h1>

            <p class="text-gray-500 mt-2">
                Sistem Informasi Peminjaman Ruang dan Fasilitas Kampus
            </p>

        </div>

        <button
        onclick="window.print()"
        class="mr-8 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow-lg print:hidden">

            <i class="fa-solid fa-print"></i>
            Cetak PDF

        </button>

    </div>

    <!-- BUTTON -->
    <div class="mb-6 print:hidden">

        <a href="form.php"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-lg">

            <i class="fa-solid fa-user-plus"></i>
            Tambah User

        </a>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-lg p-8 overflow-x-auto">

        <table class="w-full text-left">

            <thead>

                <tr class="border-b text-gray-600">

                    <th class="pb-4">ID</th>
                    <th class="pb-4">Nama</th>
                    <th class="pb-4">Email</th>
                    <th class="pb-4">Password</th>
                    <th class="pb-4">Role</th>
                </tr>

            </thead>

            <tbody class="text-gray-700">

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">1</td>
                    <td>Admin SIPRAF</td>
                    <td>admin@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Admin</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">2</td>
                    <td>Reza Firmansyah</td>
                    <td>reza.firmansyah@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Supervisor</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">3</td>
                    <td>Dewi Kusuma</td>
                    <td>dewi.kusuma@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Supervisor</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">4</td>
                    <td>Hendra Saputra</td>
                    <td>hendra.saputra@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Supervisor</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">5</td>
                    <td>Siti Rahayu</td>
                    <td>siti.rahayu@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Supervisor</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">6</td>
                    <td>Bagas Wicaksono</td>
                    <td>bagas.wicaksono@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Supervisor</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">7</td>
                    <td>Fajar Nugroho</td>
                    <td>fajar.nugroho@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Borrower</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">8</td>
                    <td>Anisa Putri</td>
                    <td>anisa.putri@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Borrower</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">9</td>
                    <td>Dimas Ardiansyah</td>
                    <td>dimas.ardiansyah@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Borrower</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">10</td>
                    <td>Laila Maharani</td>
                    <td>laila.maharani@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Borrower</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">11</td>
                    <td>Rizky Pratama</td>
                    <td>rizky.pratama@sipraf.com</td>
                    <td>da0cc0d2a8e07b7fb902836e5a415c54</td>
                    <td>Borrower</td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>