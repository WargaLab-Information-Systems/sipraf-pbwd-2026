<div class="w-64 h-screen bg-white border-r fixed left-0 top-0 flex flex-col justify-between overflow-y-auto">

    <!-- Top -->
    <div>

        <!-- Logo -->
        <div class="p-6 border-b text-center text-2xl font-bold text-blue-600">
            SIPRAF
        </div>

        <!-- Menu -->
        <div class="p-4 space-y-4 text-gray-700">

            <!-- Dashboard -->
            <a href="/project_akhir/pages/dashboard/index.php" 
               class="block px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                Dashboard
            </a>

            <!-- Master Data -->
            <div class="mt-6">
                <p class="text-xs text-gray-400 mb-2 uppercase tracking-wider">Master Data</p>

                <a href="/project_akhir/pages/facilities/index.php" 
                   class="block ml-2 px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Facilities
                </a>

                <a href="/project_akhir/pages/users/index.php" 
                   class="block ml-2 px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Users
                </a>
            </div>

            <!-- Feature -->
            <div class="mt-6">
                <p class="text-xs text-gray-400 mb-2 uppercase tracking-wider">Feature</p>

                <a href="/project_akhir/pages/reservation/index.php" 
                   class="block ml-2 px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Peminjaman
                </a>

                <a href="/project_akhir/pages/approval/index.php" 
                   class="block ml-2 px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Persetujuan
                </a>
            </div>

        </div>

    </div>

    <!-- Bottom -->
    <div class="p-4 border-t">

        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-blue-500 rounded-full"></div>

            <span class="font-semibold text-gray-700">
                Profile_name
            </span>
        </div>

        <a href="#" 
           class="block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
            Logout
        </a>

    </div>

</div>