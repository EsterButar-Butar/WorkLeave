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
</head>
<body class="bg-[#FFFFFF] text-wl-black min-h-screen flex antialiased">

    <!-- Panggil Sidebar User -->
    @include('user.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-6 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- Header Title -->
                <div>
                    <h1 class="text-3xl font-bold text-[#2D2D2D] tracking-tight">Riwayat Cuti</h1>
                    
                    <!-- Tab Navigation Switcher -->
                    <div class="flex items-center gap-8 mt-4 border-b border-gray-200">
                        <a href="{{ url('/leave/create') }}" class="pb-3 text-sm font-medium text-[#5D5D5D] hover:text-[#C12132] transition-all">
                            Pengajuan Cuti
                        </a>
                        <a href="{{ url('/leave/history') }}" class="pb-3 text-sm font-semibold text-[#C12132] border-b-2 border-[#C12132] transition-all">
                            Riwayat Cuti
                        </a>
                    </div>
                </div>

                <!-- CONTAINER UTAMA -->
                <div class="bg-[#F4D3D4]/50 rounded-3xl p-8 border border-red-200/40 shadow-[0_4px_24px_rgba(0,0,0,0.02)] space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-[#2D2D2D]">Riwayat Cuti</h2>
                        <p class="text-xs text-[#5D5D5D] mt-1">Berikut adalah daftar pengajuan cuti yang pernah Anda ajukan.</p>
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
                                    <!-- Baris 1 -->
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-4 px-5 font-medium">01</td>
                                        <td class="py-4 px-5 font-semibold">Cuti Tahunan</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">18 - 21 September 2026</td>
                                        <td class="py-4 px-5 font-medium">4 Hari</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">15 September 2026</td>
                                        <td class="py-4 px-5">
                                            <span class="px-3 py-1 rounded-full bg-[#FEF3C7] text-[#D97706] font-semibold">Menunggu</span>
                                        </td>
                                        <td class="py-4 px-5 text-center">
                                            <button onclick="openDetailModal('Cuti Tahunan', '18 - 21 September 2026', '4 Hari', '15 September 2026', 'Menunggu', 'Mengajukan cuti tahunan untuk keperluan keluarga.', 'surat_pengajuan_cuti.pdf')" class="inline-flex p-1.5 rounded-lg border border-gray-200 hover:bg-gray-100 text-gray-600 transition-colors cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Baris 2 -->
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-4 px-5 font-medium">02</td>
                                        <td class="py-4 px-5 font-semibold">Cuti Sakit</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">10 - 11 Agustus 2026</td>
                                        <td class="py-4 px-5 font-medium">2 Hari</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">9 Agustus 2026</td>
                                        <td class="py-4 px-5">
                                            <span class="px-3 py-1 rounded-full bg-[#DCFCE7] text-[#16A34A] font-semibold">Disetujui</span>
                                        </td>
                                        <td class="py-4 px-5 text-center">
                                            <button onclick="openDetailModal('Cuti Sakit', '10 - 11 Agustus 2026', '2 Hari', '9 Agustus 2026', 'Disetujui', 'Mengajukan cuti sakit karena demam tinggi.', 'surat_sakit_dokter.pdf')" class="inline-flex p-1.5 rounded-lg border border-gray-200 hover:bg-gray-100 text-gray-600 transition-colors cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Baris 3 -->
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-4 px-5 font-medium">03</td>
                                        <td class="py-4 px-5 font-semibold">Cuti Tahunan</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">2 - 6 Juli 2026</td>
                                        <td class="py-4 px-5 font-medium">5 Hari</td>
                                        <td class="py-4 px-5 text-[#5D5D5D]">28 Juni 2026</td>
                                        <td class="py-4 px-5">
                                            <span class="px-3 py-1 rounded-full bg-[#FEE2E2] text-[#DC2626] font-semibold">Ditolak</span>
                                        </td>
                                        <td class="py-4 px-5 text-center">
                                            <button onclick="openDetailModal('Cuti Tahunan', '2 - 6 Juli 2026', '5 Hari', '28 Juni 2026', 'Ditolak', 'Keperluan pribadi ke luar kota.', 'surat_cuti_juli.pdf')" class="inline-flex p-1.5 rounded-lg border border-gray-200 hover:bg-gray-100 text-gray-600 transition-colors cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                            </button>
                                        </td>
                                    </tr>
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
            
            <!-- Header Modal dengan Background Merah Muda Agak Gelap di Atas -->
            <div class="flex items-center justify-between px-8 py-6 bg-[#F5D6D8] border-b border-red-200/60">
                <h3 class="text-2xl font-bold text-[#2D2D2D] brand-font">Detail Pengajuan Cuti</h3>
                <button onclick="closeDetailModal()" class="w-10 h-10 rounded-full bg-transparent hover:bg-white/60 flex items-center justify-center text-gray-600 hover:text-[#C12132] transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content Details dengan Background Putih -->
            <div class="p-8 space-y-4 text-sm text-[#2D2D2D] bg-white">
                
                <!-- Jenis Cuti -->
                <div class="grid grid-cols-3 items-center py-2">
                    <span class="text-[#5D5D5D] font-medium">Jenis Cuti</span>
                    <div class="col-span-2">
                        <span id="modalJenisCuti" class="px-4 py-1.5 rounded-xl border border-red-200 bg-[#FEE2E2]/60 text-[#C12132] font-semibold text-xs inline-block">
                            Cuti Tahunan
                        </span>
                    </div>
                </div>

                <!-- Periode Cuti -->
                <div class="grid grid-cols-3 items-center py-2">
                    <span class="text-[#5D5D5D] font-medium">Periode Cuti</span>
                    <span id="modalPeriode" class="col-span-2 font-semibold text-[#2D2D2D]">8 - 11 September 2026</span>
                </div>

                <!-- Durasi Cuti -->
                <div class="grid grid-cols-3 items-center py-2">
                    <span class="text-[#5D5D5D] font-medium">Durasi Cuti</span>
                    <span id="modalDurasi" class="col-span-2 font-semibold text-[#2D2D2D]">4 Hari</span>
                </div>

                <!-- Tanggal Pengajuan -->
                <div class="grid grid-cols-3 items-center py-2">
                    <span class="text-[#5D5D5D] font-medium">Tanggal Pengajuan</span>
                    <span id="modalTglPengajuan" class="col-span-2 font-semibold text-[#2D2D2D]">1 September 2026</span>
                </div>

                <!-- Status -->
                <div class="grid grid-cols-3 items-center py-2">
                    <span class="text-[#5D5D5D] font-medium">Status</span>
                    <div class="col-span-2">
                        <span id="modalStatus" class="px-4 py-1.5 rounded-xl border font-semibold text-xs inline-block">
                            Disetujui
                        </span>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="grid grid-cols-3 items-start py-2">
                    <span class="text-[#5D5D5D] font-medium pt-1">Keterangan</span>
                    <p id="modalKeterangan" class="col-span-2 text-[#2D2D2D] leading-relaxed">
                        Mengajukan cuti tahunan untuk keperluan mengunjungi keluarga di luar kota.
                    </p>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="grid grid-cols-3 items-start py-2">
                    <span class="text-[#5D5D5D] font-medium pt-2">Dokumen Pendukung</span>
                    <div class="col-span-2">
                        <div class="flex items-center justify-between p-3.5 bg-white border border-red-100 rounded-2xl shadow-xs">
                            <div class="flex items-center gap-3">
                                <div class="text-[#C12132]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 id="modalFileNama" class="text-xs font-bold text-[#2D2D2D]">surat_pengajuan_cuti.pdf</h4>
                                    <p class="text-[10px] text-[#5D5D5D]">245 KB</p>
                                </div>
                            </div>
                            <a href="#" class="p-2 text-gray-500 hover:text-[#C12132] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
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

        function openDetailModal(jenis, periode, durasi, tglPengajuan, status, keterangan, fileName) {
            // Masukkan data dinamis ke elemen modal
            document.getElementById('modalJenisCuti').innerText = jenis;
            document.getElementById('modalPeriode').innerText = periode;
            document.getElementById('modalDurasi').innerText = durasi;
            document.getElementById('modalTglPengajuan').innerText = tglPengajuan;
            document.getElementById('modalKeterangan').innerText = keterangan;
            document.getElementById('modalFileNama').innerText = fileName;

            // Styling Badge Status di Modal
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.innerText = status;
            statusBadge.className = "px-4 py-1.5 rounded-xl border font-semibold text-xs inline-block"; // reset class

            if (status === 'Disetujui') {
                statusBadge.classList.add('bg-[#DCFCE7]', 'border-[#BBF7D0]', 'text-[#16A34A]');
            } else if (status === 'Ditolak') {
                statusBadge.classList.add('bg-[#FEE2E2]', 'border-[#FECACA]', 'text-[#DC2626]');
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

        // Tutup modal jika klik di luar box modal
        window.onclick = function(event) {
            if (event.target == modal) {
                closeDetailModal();
            }
        }
    </script>

</body>
</html>