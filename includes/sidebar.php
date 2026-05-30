<div class="w-64 h-screen bg-gray-950 text-gray-300 flex flex-col justify-between border-r border-gray-800 font-sans">
    
    <div>
        <div class="p-6 border-b border-gray-800 flex items-center justify-center">
            <h1 class="text-2xl font-bold tracking-wider text-white">SIPRAF</h1>
        </div>

        <nav class="p-4 space-y-6">
            
            <div>
                <a href="../../pages/dashboard/index.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    Dashboard
                </a>
            </div>

            <div>
                <span class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Master Data</span>
                <div class="space-y-1">
                    <a href="../../pages/facilities/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Facilities
                    </a>
                    <a href="../../pages/users/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Users
                    </a>
                </div>
            </div>

            <div>
                <span class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Feature</span>
                <div class="space-y-1">
                    <a href="../../pages/reservation/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Peminjaman
                    </a>
                    <a href="../../pages/approval/index.php" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Persetujuan
                    </a>
                </div>
            </div>

        </nav>
    </div>

    <div class="p-4 border-t border-gray-800 flex items-center justify-between bg-gray-900/50">
        <a href="../../pages/profile/index.php" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-sm group-hover:bg-blue-500 transition-colors">
                U
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors leading-tight">Profile_name</span>
                <span class="text-xs text-gray-500">User</span>
            </div>
        </a>

        <a href="../../logic/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" class="text-gray-500 hover:text-red-400 p-2 rounded-lg hover:bg-gray-800 transition-colors" title="Logout">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        </a>
    </div>

</div>