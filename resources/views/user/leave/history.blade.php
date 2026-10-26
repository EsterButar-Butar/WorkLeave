<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Cuti - WorkLeave</title>
    
    <!-- Google Fonts -->
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
    <!-- Alpine.js untuk Dropdown Profil & Logout -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FFFFFF] text-wl-black min-h-screen flex antialiased">

    <!-- Panggil Sidebar User -->
    @include('user.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-6 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- Header Title & User Profile Dropdown -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-[#2D2D2D] tracking-tight">Riwayat Cuti</h1>
                        
                        <!-- Tab Navigation Switcher -->
                        <div class="flex items-center gap-8 mt-4 border-b border-gray-200">
                            <a href="{{ route('leave.create') }}" class="pb-3 text-sm font-medium text-[#5D5D5D] hover:text-[#C12132] transition-all">
                                Pengajuan Cuti
                            </a>
                            <a href="{{ route('leave.history') }}" class="pb-3 text-sm font-semibold text-[#C12132] border-b-2 border-[#C12132] transition-all">
                                Riwayat Cuti
                            </a>
                        </div>
                    </div>

                    <!-- Profil Button & Logout Dropdown -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown" class="flex items-center gap-3 bg-white border border-gray-100 shadow-sm px-4 py-2 rounded-2xl cursor-pointer focus:outline-none hover:bg-gray-50/80 transition-all">
                            <div class="w-9 h-9 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-semibold text-[#2D2D2D] leading-tight">{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'Admin' : Auth::user()->name }}</div>
                                <div class="text-xs text-[#5D5D5D] leading-tight mt-0.5">{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'Admin' : (Auth::user()->position ?? 'Mitra Kerja') }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Menu Dropdown Logout -->
                        <div x-show="openDropdown" 
                             @click.away="openDropdown = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-full min-w-[160px] bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] border border-gray-100 py-2 z-50 hidden"
                             :class="{ 'hidden': !openDropdown }">
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-[#C12132] hover:bg-red-50/60 transition-colors cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- CONTAINER UTAMA -->
                <div class="bg-[#F4D3D4]/50 rounded-3xl p-8 border border-red-200/40 shadow-[0_4px_24px_rgba(0,0,0,0.02)] space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-[#2D2D2D]">Riwayat Cuti</h2>
                        <p class="text-xs text-[#5D5D5D] mt-1">Berikut adalah daftar pengajuan cuti yang pernah Anda ajukan ke sistem WorkLeave.</p>
                    </div>

                    <!-- TABEL -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-xs border border-gray-100">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-200/70 text-[#2D2D2D] text-xs font-bold uppercase tracking-wider">
                                        <th class="py-4 px-5">No</th>
                                        <th class="py-4 px-5">Jenis Cuti</th>
                                        <th class="py-4 px-5">Periode Cuti</th>
                                        <th class="py-4 px-5">Durasi Cuti</th>
                                        <th class="py-4 px-5">Tanggal Pengajuan</th>
                                        <th class="py-4 px-5">Status</th>
                                        <th class="py-4 px-5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs text-[#2D2D2D]">
                                    @forelse ($leaveRequests ?? [] as $index => $req)
                                        @php
                                            $statusVal = $req->status->value ?? $req->status;
                                            $statusClass = match($statusVal) {
                                                'approved' => 'bg-[#DCFCE7] text-[#16A34A]',
                                                'rejected' => 'bg-[#FEE2E2] text-[#DC2626]',
                                                'cancelled' => 'bg-gray-100 text-gray-600',
                                                default => 'bg-[#FEF3C7] text-[#D97706]',
                                            };
                                            $statusLabel = match($statusVal) {
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'cancelled' => 'Dibatalkan',
                                                default => 'Menunggu',
                                            };
                                            $startDateFormatted = \Carbon\Carbon::parse($req->start_date)->translatedFormat('d F Y');
                                            $endDateFormatted = \Carbon\Carbon::parse($req->end_date)->translatedFormat('d F Y');
                                            $periodFormatted = ($req->start_date == $req->end_date)
                                                ? $startDateFormatted
                                                : (\Carbon\Carbon::parse($req->start_date)->translatedFormat('d') . ' - ' . $endDateFormatted);
                                            $createdFormatted = \Carbon\Carbon::parse($req->created_at)->translatedFormat('d F Y');
                                            $attachmentName = $req->attachment_path ? basename($req->attachment_path) : null;
                                            $attachmentUrl = $req->attachment_path ? route('leave.attachment', $req->id) : null;
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-5 font-medium">{{ sprintf('%02d', $index + 1) }}</td>
                                            <td class="py-4 px-5 font-semibold text-[#2D2D2D]">{{ $req->leaveType->name ?? 'Cuti' }}</td>
                                            <td class="py-4 px-5 text-[#5D5D5D]">{{ $periodFormatted }}</td>
                                            <td class="py-4 px-5 font-medium text-[#2D2D2D]">{{ $req->total_days }} Hari</td>
                                            <td class="py-4 px-5 text-[#5D5D5D]">{{ $createdFormatted }}</td>
                                            <td class="py-4 px-5">
                                                <span class="px-3 py-1 rounded-full {{ $statusClass }} font-semibold">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-5 text-center">
                                                <button type="button" 
                                                        onclick="openDetailModal(
                                                            '{{ addslashes($req->leaveType->name ?? 'Cuti') }}',
                                                            '{{ addslashes($periodFormatted) }}',
                                                            '{{ $req->total_days }} Hari',
                                                            '{{ addslashes($createdFormatted) }}',
                                                            '{{ $statusLabel }}',
                                                            '{{ addslashes($req->reason ?? '-') }}',
                                                            '{{ $attachmentName ? addslashes($attachmentName) : '' }}',
                                                            '{{ $attachmentUrl ? addslashes($attachmentUrl) : '' }}'
                                                        )" 
                                                        class="inline-flex p-1.5 rounded-lg border border-gray-200 hover:bg-gray-100 text-gray-600 transition-colors cursor-pointer"
                                                        title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-12 text-center text-gray-400">
                                                <div class="flex flex-col items-center justify-center space-y-3">
                                                    <div class="w-12 h-12 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-gray-400 shadow-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-500">Belum ada riwayat pengajuan cuti</p>
                                                    <a href="{{ route('leave.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#C12132] text-white text-xs font-semibold hover:bg-[#9B0010] transition-all shadow-sm shadow-red-500/20">
                                                        <span>Ajukan Cuti Baru</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- POP UP DETAIL -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs hidden transition-all duration-300">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.15)] overflow-hidden relative transform scale-95 transition-all duration-300" id="modalContainer">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between px-8 py-6 bg-[#F5D6D8] border-b border-red-200/60">
                <h3 class="text-2xl font-bold text-[#2D2D2D] brand-font">Detail Pengajuan Cuti</h3>
                <button onclick="closeDetailModal()" class="w-10 h-10 rounded-full bg-transparent hover:bg-white/60 flex items-center justify-center text-gray-600 hover:text-[#C12132] transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content Details -->
            <div class="p-8 space-y-4 text-sm text-[#2D2D2D] bg-white">
                
                <!-- Jenis Cuti -->
                <div class="grid grid-cols-3 items-center py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium">Jenis Cuti</span>
                    <div class="col-span-2">
                        <span id="modalJenisCuti" class="px-4 py-1.5 rounded-xl border border-red-200 bg-[#FEE2E2]/60 text-[#C12132] font-semibold text-xs inline-block">
                            Cuti Tahunan
                        </span>
                    </div>
                </div>

                <!-- Periode Cuti -->
                <div class="grid grid-cols-3 items-center py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium">Periode Cuti</span>
                    <span id="modalPeriode" class="col-span-2 font-semibold text-[#2D2D2D]">-</span>
                </div>

                <!-- Durasi Cuti -->
                <div class="grid grid-cols-3 items-center py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium">Durasi Cuti</span>
                    <span id="modalDurasi" class="col-span-2 font-semibold text-[#2D2D2D]">-</span>
                </div>

                <!-- Tanggal Pengajuan -->
                <div class="grid grid-cols-3 items-center py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium">Tanggal Pengajuan</span>
                    <span id="modalTglPengajuan" class="col-span-2 font-semibold text-[#2D2D2D]">-</span>
                </div>

                <!-- Status -->
                <div class="grid grid-cols-3 items-center py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium">Status</span>
                    <div class="col-span-2">
                        <span id="modalStatus" class="px-4 py-1.5 rounded-xl border font-semibold text-xs inline-block">
                            Menunggu
                        </span>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="grid grid-cols-3 items-start py-2 border-b border-gray-50">
                    <span class="text-[#5D5D5D] font-medium pt-1">Keterangan</span>
                    <p id="modalKeterangan" class="col-span-2 text-[#2D2D2D] leading-relaxed">
                        -
                    </p>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="grid grid-cols-3 items-start py-2">
                    <span class="text-[#5D5D5D] font-medium pt-2">Dokumen Pendukung</span>
                    <div class="col-span-2">
                        <!-- Box Dokumen Ada -->
                        <div id="modalDokumenContainer" class="hidden flex items-center justify-between p-3.5 bg-white border border-red-100 rounded-2xl shadow-xs">
                            <div class="flex items-center gap-3">
                                <div class="text-[#C12132]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 id="modalFileNama" class="text-xs font-bold text-[#2D2D2D]">surat_pendukung.pdf</h4>
                                    <p class="text-[10px] text-[#5D5D5D]">Dokumen Terlampir</p>
                                </div>
                            </div>
                            <a id="modalDownloadBtn" href="#" target="_blank" class="p-2 text-gray-500 hover:text-[#C12132] transition-colors" title="Unduh Berkas">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
                        <!-- Teks Dokumen Tidak Ada -->
                        <span id="modalNoDokumen" class="text-xs text-gray-400 italic">Tidak ada dokumen pendukung dilampirkan.</span>
                    </div>
                </div>

            </div>

            <!-- Footer Button -->
            <div class="px-8 pb-8 pt-2 bg-white flex justify-end">
                <button onclick="closeDetailModal()" class="px-8 py-3 bg-[#C12132] hover:bg-[#9B0010] text-white font-medium rounded-xl shadow-[0_4px_15px_rgba(193,33,50,0.25)] transition-all text-sm cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT UNTUK MODAL POP-UP -->
    <script>
        const modal = document.getElementById('detailModal');
        const modalContainer = document.getElementById('modalContainer');

        function openDetailModal(jenis, periode, durasi, tglPengajuan, status, keterangan, fileName, downloadUrl) {
            document.getElementById('modalJenisCuti').innerText = jenis;
            document.getElementById('modalPeriode').innerText = periode;
            document.getElementById('modalDurasi').innerText = durasi;
            document.getElementById('modalTglPengajuan').innerText = tglPengajuan;
            document.getElementById('modalKeterangan').innerText = keterangan;

            const docContainer = document.getElementById('modalDokumenContainer');
            const noDoc = document.getElementById('modalNoDokumen');
            const fileNama = document.getElementById('modalFileNama');
            const downloadBtn = document.getElementById('modalDownloadBtn');

            if (fileName && downloadUrl) {
                fileNama.innerText = fileName;
                downloadBtn.href = downloadUrl;
                docContainer.classList.remove('hidden');
                noDoc.classList.add('hidden');
            } else {
                docContainer.classList.add('hidden');
                noDoc.classList.remove('hidden');
            }

            // Styling Badge Status di Modal
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.innerText = status;
            statusBadge.className = "px-4 py-1.5 rounded-xl border font-semibold text-xs inline-block";

            if (status === 'Disetujui') {
                statusBadge.classList.add('bg-[#DCFCE7]', 'border-[#BBF7D0]', 'text-[#16A34A]');
            } else if (status === 'Ditolak') {
                statusBadge.classList.add('bg-[#FEE2E2]', 'border-[#FECACA]', 'text-[#DC2626]');
            } else if (status === 'Dibatalkan') {
                statusBadge.classList.add('bg-gray-100', 'border-gray-200', 'text-gray-600');
            } else {
                statusBadge.classList.add('bg-[#FEF3C7]', 'border-[#FDE68A]', 'text-[#D97706]');
            }

            // Tampilkan modal 
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContainer.classList.remove('scale-95');
                modalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeDetailModal() {
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeDetailModal();
            }
        }
    </script>

</body>
</html>