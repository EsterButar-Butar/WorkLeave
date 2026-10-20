<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WorkLeave</title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF !important; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wl-red-dark': '#9B0010',
                        'wl-red-light': '#FA232B',
                        'wl-black': '#2D2D2D',
                        'wl-grey-dark': '#5D5D5D',
                        'wl-grey-light': '#B2B3B8',
                        'wl-white': '#FFFFFF',
                        'wl-sidebar-bg': '#FFFBFB'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#FFFFFF] text-[#2D2D2D] min-h-screen flex antialiased">


    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-8 lg:p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-8 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- HEADER ATAS: LOGO & JUDUL DASHBOARD -->
                <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-6 pb-2 relative min-h-[160px]">
                    <div class="max-w-xl">
                        <!-- Logo Header -->
                        <div class="flex items-center gap-2.5 mb-4">
                            <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-10 w-auto object-contain">
                            <span class="text-2xl font-bold tracking-tight text-[#C12132]">WorkLeave</span>
                        </div>

                        <p class="text-xs text-[#5D5D5D] font-medium">Selamat Datang Admin,</p>
                        <h1 class="text-2xl lg:text-3xl font-extrabold text-[#2D2D2D] tracking-tight mt-0.5">
                            Dashboard Admin
                        </h1>
                        <p class="text-xs text-[#8C8C8C] mt-1">
                            Kelola pengajuan cuti, data pegawai, dan keputusan admin
                        </p>
                    </div>

                    <!-- NOTIFIKASI PENGAJUAN CUTI (SESUAI DESAIN FIGMA) -->
                    <div class="w-full xl:w-auto xl:absolute xl:right-0 xl:top-0 z-10 flex flex-col items-end">
                        @include('admin.dashboard.popup-request')
                    </div>
                </div>

                <!-- 1. KARTU STATISTIK METRIK ADMIN -->
                @include('admin.dashboard.cards')

                <!-- 2. GRID UTAMA: TABEL KUOTA CUTI (KIRI) & PEGAWAI CUTI SAAT INI (KANAN) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start bg-[#FFFFFF]">
                    <!-- Kolom Kiri: Tabel Kuota Cuti Pegawai -->
                    <div class="xl:col-span-8">
                        @include('admin.dashboard.quota-table')
                    </div>

                    <!-- Kolom Kanan: Pegawai Cuti Saat Ini -->
                    <div class="xl:col-span-4">
                        @include('admin.dashboard.today-leave')
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL RIWAYAT PENGAJUAN CUTI -->
    <div id="riwayatModal"
         class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/50 backdrop-blur-sm p-3 sm:p-5"
         style="height: 100vh; width: 100%; box-sizing: border-box;"
         aria-hidden="true"
         role="dialog"
         aria-label="Riwayat Pengajuan Cuti">

        <div class="relative flex flex-col w-full max-w-[1200px] overflow-hidden rounded-2xl bg-white shadow-2xl"
             style="height: 90vh; max-height: 90vh; min-height: 0;">

            <!-- Loading Indicator -->
            <div id="riwayatLoading"
                 class="hidden absolute inset-0 z-10 flex items-center justify-center bg-white/80 rounded-2xl">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-8 h-8 border-4 border-[#C12132]/20 border-t-[#C12132] rounded-full animate-spin"></div>
                    <span class="text-xs text-[#5D5D5D] font-medium">Memuat data...</span>
                </div>
            </div>

            <iframe
                id="riwayatFrame"
                src="about:blank"
                title="Riwayat Pengajuan Cuti"
                class="h-full w-full flex-1 border-0 bg-white"
                loading="lazy">
            </iframe>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal   = document.getElementById('riwayatModal');
            const frame   = document.getElementById('riwayatFrame');
            const loading = document.getElementById('riwayatLoading');

            /** Buka modal dengan url riwayat pegawai */
            function openRiwayat(url) {
                // Tambahkan ?modal=1 agar history.blade.php tahu ini mode iframe
                const modalUrl = new URL(url, window.location.origin);
                modalUrl.searchParams.set('modal', '1');

                // Tutup notifikasi pengajuan cuti jika masih terbuka
                if (typeof closeLeaveNotification === 'function') {
                    closeLeaveNotification();
                } else {
                    const notification = document.getElementById('leaveRequestPopup');
                    const reopenBtn    = document.getElementById('reopenNotificationBtn');
                    if (notification) notification.classList.add('hidden');
                    if (reopenBtn) {
                        reopenBtn.classList.remove('hidden');
                        reopenBtn.classList.add('flex');
                    }
                }

                // Tampilkan loading lalu load iframe
                loading.classList.remove('hidden');
                frame.src = modalUrl.toString();

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            }

            /** Tutup modal */
            function closeRiwayat() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.setAttribute('aria-hidden', 'true');
                frame.src = 'about:blank';
                loading.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Sembunyikan loading saat iframe selesai dimuat
            frame.addEventListener('load', function () {
                loading.classList.add('hidden');
            });

            // Pasang event listener ke semua tombol Detail yang punya data-riwayat-modal
            document.querySelectorAll('[data-riwayat-modal]').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    openRiwayat(this.href);
                });
            });

            // Klik di luar modal box → tutup
            modal.addEventListener('click', function (event) {
                if (event.target === modal) closeRiwayat();
            });

            // Tekan Escape → tutup
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeRiwayat();
                }
            });

            // Terima pesan postMessage dari iframe (tombol Tutup di history.blade.php)
            window.addEventListener('message', function (event) {
                if (event.origin === window.location.origin && event.data === 'workleave:close-riwayat') {
                    closeRiwayat();
                }
            });
        });
    </script>
    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] flex flex-col gap-3 w-full max-w-2xl px-4 pointer-events-none"></div>

    <script>
        /**
         * Tampilkan toast notification sesuai aksi yang dipilih admin.
         * @param {string} action - 'setujui' | 'tunda' | 'tolak'
         */
        function showToastNotification(action) {
            const config = {
                setujui: {
                    icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                           </svg>`,
                    iconBg  : 'bg-emerald-100 text-emerald-600',
                    wrapBg  : 'bg-[#F0FDF8] border-emerald-200',
                    titleCls: 'text-[#10B981]',
                    title   : 'Pengajuan Berhasil Disetujui!',
                    desc    : 'Pengajuan cuti Siti (11/10/2026 – 13/10/2026) telah masuk dan dicatat di baris pertama tabel riwayat.',
                },
                tunda: {
                    icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"/>
                           </svg>`,
                    iconBg  : 'bg-amber-100 text-amber-600',
                    wrapBg  : 'bg-[#FFFBEB] border-amber-200',
                    titleCls: 'text-[#D97706]',
                    title   : 'Pengajuan Berhasil Ditunda!',
                    desc    : 'Pengajuan cuti Siti (11/10/2026 – 13/10/2026) telah ditunda dan akan diproses kembali.',
                },
                tolak: {
                    icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                           </svg>`,
                    iconBg  : 'bg-rose-100 text-rose-600',
                    wrapBg  : 'bg-[#FFF1F2] border-rose-200',
                    titleCls: 'text-[#DC2626]',
                    title   : 'Pengajuan Berhasil Ditolak!',
                    desc    : 'Pengajuan cuti Siti (11/10/2026 – 13/10/2026) telah ditolak dan akan diberitahukan kepada pegawai.',
                },
            };

            const c = config[action];
            if (!c) return;

            // Buat elemen toast
            const toast = document.createElement('div');
            toast.className = `pointer-events-auto flex items-start gap-4 w-full px-5 py-4 rounded-2xl border shadow-lg ${c.wrapBg} 
                               opacity-0 translate-y-4 transition-all duration-300`;
            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 ${c.iconBg}">
                    ${c.icon}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold ${c.titleCls}">${c.title}
                        <span class="font-normal text-[#2D2D2D] ml-1">${c.desc}</span>
                    </p>
                </div>
                <button onclick="this.closest('[data-toast]').remove()"
                        class="text-gray-400 hover:text-gray-600 transition-colors shrink-0 mt-0.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            toast.setAttribute('data-toast', '');

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            // Animasi masuk
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                });
            });

            // Auto-dismiss setelah 5 detik
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    </script>

</body>
</html>
