<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .menu-card {
            transition: all 0.35s ease;
            backdrop-filter: blur(10px);
        }
        .menu-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 25px rgba(59,130,246,0.15);
        }
        .bg-2025 {
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 40%, #e0f2fe 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
    </style>
    <body class="bg-2025 text-slate-800 relative">

        <!-- Decorative blurred shapes -->
        <div class="absolute top-16 left-20 w-40 h-40 bg-indigo-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-24 w-56 h-56 bg-sky-200/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-0 w-24 h-24 bg-fuchsia-200/20 rounded-full blur-2xl"></div>

        <!-- Hero Section -->
        <section class="text-center mt-12 mb-12 px-6 relative">
            <div class="absolute left-1/2 -translate-x-1/2 top-0 opacity-10">
                <div data-lucide="rocket" class="text-indigo-500 w-20 h-20"></div>
            </div>

            <h1 class="text-3xl font-bold text-slate-800 mb-2 tracking-tight">
                Selamat Datang di <span class="text-indigo-600">SAS Portal</span>
            </h1>

            <p class="text-slate-500 text-sm max-w-xl mx-auto flex items-center justify-center gap-1">
                {{-- <div data-lucide="info" class="text-indigo-400 w-4 h-4"></div> --}}
                Kelola aktivitas harian, proyek, dan absensi digital Anda dengan antarmuka baru versi 2025.
            </p>
        </section>

        <!-- Grid Menu -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8 w-full max-w-5xl mx-auto px-6 pb-16">

            <a href="{{ route('daily-report') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="clipboard-list" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">Daily Log</span>
                <p class="text-xs text-slate-500 mt-1">Catat aktivitas harian</p>
            </a>

            <a href="{{ url('projects') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-orange-400 to-amber-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="briefcase" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">Project</span>
                <p class="text-xs text-slate-500 mt-1">Pantau progres proyek</p>
            </a>

            <a href="{{ url('to-do-list') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="check-square" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">ToDo</span>
                <p class="text-xs text-slate-500 mt-1">Daftar tugas penting</p>
            </a>

            <a href="{{ url('daftarkan_finger') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-sky-500 to-indigo-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="fingerprint" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">Daftarkan Finger</span>
                <p class="text-xs text-slate-500 mt-1">Aktivasi absensi digital</p>
            </a>

            <a href="{{ url('dashboard') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-purple-500 to-fuchsia-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="bar-chart-3" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">Dashboard</span>
                <p class="text-xs text-slate-500 mt-1">Lihat statistik harian</p>
            </a>

            <a href="{{ url('pengaturan') }}" class="menu-card bg-white/70 border border-white/50 rounded-2xl p-8 text-center shadow-sm flex flex-col items-center">
                <div class="p-4 bg-gradient-to-br from-rose-500 to-pink-500 rounded-xl shadow-md mb-4">
                    <div data-lucide="settings" class="text-white w-10 h-10"></div>
                </div>
                <span class="font-semibold text-slate-800 text-lg">Pengaturan</span>
                <p class="text-xs text-slate-500 mt-1">Atur akun & preferensi</p>
            </a>

        </div>

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>

    </body>
</div>
