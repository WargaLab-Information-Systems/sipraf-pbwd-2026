<!-- SIDEBAR -->
<aside class="w-72 bg-white border-r shadow-sm flex flex-col justify-between print:hidden">

    <!-- TOP -->
    <div>

        <!-- LOGO -->
        <div class="p-8 border-b">

            <h1 class="text-4xl font-bold text-center text-black">
                SIPRAF
            </h1>

        </div>

        <!-- MENU -->
        <div class="p-6">

            <!-- DASHBOARD -->
            <div class="mb-10">

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Dashboard
                </p>

                <a href="../dashboard/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                    <i class="fa-solid fa-chart-line text-gray-600"></i>

                    <span class="font-medium text-gray-700">
                        Dashboard
                    </span>

                </a>

            </div>

            <!-- MASTER DATA -->
            <div class="mb-10">

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Master Data
                </p>

                <div class="space-y-2">

                    <a href="index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold">

                        <i class="fa-solid fa-building"></i>Facilities
                    </a>

                    <a href="../users/index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-users"></i>Users
                    </a>

                </div>

            </div>

            <!-- FEATURE -->
            <div>

                <p class="text-gray-400 text-sm font-semibold mb-4 uppercase">
                    Feature
                </p>

                <div class="space-y-2">

                    <a href="../reservation/index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-calendar-check"></i>Peminjaman
                    </a>

                    <a href="../approval/index.php"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

                        <i class="fa-solid fa-circle-check"></i>Persetujuan
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- BOTTOM -->
    <div class="p-6 border-t">

        <div class="flex items-center justify-between">

            <!-- PROFILE -->
            <a href="profile/index.php"
                class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-full bg-gray-300"></div>

                <div>

                    <h2 class="font-semibold text-gray-700">
                        Profile_name
                    </h2>
                </div>

            </a>

            <!-- LOGOUT -->
            <button
                class="w-10 h-10 rounded-full bg-gray-200 hover:bg-red-500 hover:text-white transition">

                <i class="fa-solid fa-right-from-bracket"></i>

            </button>

        </div>

    </div>

</aside>