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

                    <a href="../facilities/index.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 transition">

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
    <a href="../profile/index.php"
       class="flex items-center gap-3">

        <div class="w-12 h-12 rounded-full bg-gray-300"></div>

        <div>
            <h2 class="font-semibold text-gray-700">
                Profile_name
            </h2>
        </div>

    </a>

    <!-- LOGOUT -->
    <a href="../auth/logout.php"
       class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-red-500 hover:text-white transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             width="20"
             height="20"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">
            <path d="m16 17 5-5-5-5"/>
            <path d="M21 12H9M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        </svg>

    </a>

</div>

    </div>

</aside>