<div class="container position-relative">

    <style>
        .menu-card {
            transition: all .35s ease;
            backdrop-filter: blur(10px);
        }

        .menu-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 25px rgba(59, 130, 246, .15);
        }

        /* .bg-2025 {
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 40%, #e0f2fe 100%);
            min-height: 100vh;
        } */
    </style>

    <div class="bg-2025">

        <!-- Hero -->
        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Selamat Datang di <span class="text-primary">SAS Portal</span>
            </h1>

            <p class="text-muted">
                Kelola aktivitas harian, proyek, dan absensi digital Anda dengan antarmuka baru versi 2025.
            </p>

        </div>

        <!-- Grid -->
        <div class="row g-4 justify-content-center">

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('daily-report') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="clipboard-list"></i>
                        </div>

                        <h6 class="fw-semibold">Daily Log</h6>
                        <small class="text-muted">Catat aktivitas harian</small>

                    </div>
                </a>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('projects') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="briefcase"></i>
                        </div>

                        <h6 class="fw-semibold">Project</h6>
                        <small class="text-muted">Pantau progres proyek</small>

                    </div>
                </a>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('to-do-list') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="check-square"></i>
                        </div>

                        <h6 class="fw-semibold">ToDo</h6>
                        <small class="text-muted">Daftar tugas penting</small>

                    </div>
                </a>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('fingerprints') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="fingerprint"></i>
                        </div>

                        <h6 class="fw-semibold">Daftarkan Finger</h6>
                        <small class="text-muted">Aktivasi absensi digital</small>

                    </div>
                </a>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="bar-chart-3"></i>
                        </div>

                        <h6 class="fw-semibold">Dashboard</h6>
                        <small class="text-muted">Lihat statistik harian</small>

                    </div>
                </a>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ url('pengaturan') }}" class="text-decoration-none">
                    <div class="menu-card card text-center p-4 h-100 shadow-sm">

                        <div class="mb-3">
                            <i data-lucide="settings"></i>
                        </div>

                        <h6 class="fw-semibold">Pengaturan</h6>
                        <small class="text-muted">Atur akun & preferensi</small>

                    </div>
                </a>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</div>
