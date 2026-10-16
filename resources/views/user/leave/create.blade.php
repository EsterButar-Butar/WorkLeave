<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti - WorkLeave</title>
    
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

    <!-- Sidebar User -->
    @include('user.sidebar')

    <!-- Main Content Wrapper -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-6 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- Header Title -->
                <div>
                    <h1 class="text-3xl font-bold text-[#2D2D2D] tracking-tight">Pengajuan Cuti</h1>
                    
                    <!-- Tab Navigation Switcher -->
                    <div class="flex items-center gap-8 mt-4 border-b border-gray-200">
                        <a href="{{ url('/leave/create') }}" class="pb-3 text-sm font-semibold text-[#C12132] border-b-2 border-[#C12132] transition-all">
                            Pengajuan Cuti
                        </a>
                        <a href="{{ url('/leave/history') }}" class="pb-3 text-sm font-medium text-[#5D5D5D] hover:text-[#C12132] transition-all">
                            Riwayat Cuti
                        </a>
                    </div>
                </div>

                <!-- Container Utama -->
                <div class="bg-[#F4D3D4]/50 rounded-3xl p-8 border border-red-200/40 shadow-[0_4px_24px_rgba(0,0,0,0.02)] space-y-6">
                    
                    <div class="space-y-6">
                        <h2 class="text-xl font-bold text-[#2D2D2D]">Form Pengajuan Cuti</h2>

                        <!-- Form dengan event onsubmit untuk menampilkan modal sukses prototype -->
                        <form onsubmit="handleFormSubmit(event)" enctype="multipart/form-data" class="space-y-5">
                            
                            <!-- Jenis Cuti -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Jenis Cuti</label>
                                <select class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm appearance-none shadow-xs">
                                    <option value="" disabled selected>Pilih Jenis Cuti</option>
                                    <option value="tahunan">Cuti Tahunan</option>
                                    <option value="sakit">Cuti Sakit</option>
                                    <option value="bersalin">Cuti Bersalin</option>
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Tanggal Mulai</label>
                                <input type="date" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm shadow-xs">
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Tanggal Selesai</label>
                                <input type="date" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm shadow-xs">
                            </div>

                            <!-- Keterangan -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Keterangan</label>
                                <input type="text" placeholder="Masukkan keterangan cuti" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] placeholder:text-gray-400 text-sm shadow-xs">
                            </div>

                            <!-- Upload File Pendukung -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Upload File Pendukung</label>
                                <div onclick="openUploadModal()" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 flex items-center justify-between cursor-pointer hover:border-gray-300 transition-all shadow-xs">
                                    <div class="flex items-center gap-3 text-sm text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <span id="uploadedFileName" class="text-xs text-gray-400">Upload file</span>
                                    </div>
                                </div>
                                <input type="file" id="realFileInput" name="file_pendukung" class="hidden" onchange="handleFileSelected(this)">
                            </div>

                            <!-- Button Submit -->
                            <div class="pt-3">
                                <button type="submit" class="w-full bg-[#C12132] hover:bg-[#9B0010] text-white font-medium py-4 rounded-xl shadow-[0_8px_25px_rgba(193,33,50,0.25)] transition-all flex items-center justify-center gap-2 text-sm cursor-pointer">
                                    <span>Ajukan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Pop Up Upload File -->
    <div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs hidden transition-all duration-300">
        <div class="bg-white w-full max-w-lg rounded-3xl p-8 shadow-[0_20px_60px_rgba(0,0,0,0.15)] space-y-6 relative transform scale-95 transition-all duration-300" id="uploadModalContainer">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-[#2D2D2D] brand-font">Upload File</h3>
                <button onclick="closeUploadModal()" class="w-8 h-8 rounded-full bg-transparent hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-[#2D2D2D] transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desc -->
            <p class="text-xs text-[#5D5D5D]">
                You can upload one file at a time, with a maximum size of 20 MB.
            </p>

            <!-- Dropzone Area -->
            <div onclick="triggerFileBrowser()" class="border-2 border-dashed border-gray-200 hover:border-[#C12132] rounded-2xl p-8 text-center cursor-pointer bg-gray-50/50 hover:bg-[#FFF5F6]/50 transition-all space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-white border border-gray-200 mx-auto flex items-center justify-center text-gray-700 shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">
                        <span class="text-[#C12132] font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-[10px] text-gray-400 mt-1">SVG, PNG, JPG, PDF or GIF (max. 800x400px)</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Pop Up Sukses Pengajuan Cuti -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs hidden transition-all duration-300">
        <div class="bg-white w-full max-w-lg rounded-3xl p-8 shadow-[0_20px_60px_rgba(0,0,0,0.15)] space-y-6 relative transform scale-95 transition-all duration-300 text-center" id="successModalContainer">
            
            <!-- Tombol Close (X) di Pojok Kanan Atas -->
            <button onclick="redirectToHistory()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-transparent hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-[#2D2D2D] transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Icon Centang Merah -->
            <div class="w-16 h-16 rounded-full bg-[#FFF5F6] border border-red-100 mx-auto flex items-center justify-center text-[#C12132] shadow-xs mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>

            <!-- Teks Informasi -->
            <div class="space-y-2">
                <h3 class="text-2xl font-bold text-[#2D2D2D] brand-font">Selamat!</h3>
                <p class="text-xs text-[#5D5D5D]">
                    Form pengajuan cuti kamu berhasil dikirim!
                </p>
            </div>

            <!-- Tombol Tutup -->
            <div class="pt-2">
                <button onclick="redirectToHistory()" class="w-full bg-[#C12132] hover:bg-[#9B0010] text-white font-medium py-3.5 rounded-xl shadow-[0_4px_15px_rgba(193,33,50,0.25)] transition-all text-sm cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- Script Javascript -->
    <script>
        const uploadModal = document.getElementById('uploadModal');
        const uploadModalContainer = document.getElementById('uploadModalContainer');
        const successModal = document.getElementById('successModal');
        const successModalContainer = document.getElementById('successModalContainer');

        function openUploadModal() {
            uploadModal.classList.remove('hidden');
            setTimeout(() => {
                uploadModalContainer.classList.remove('scale-95');
                uploadModalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeUploadModal() {
            uploadModalContainer.classList.remove('scale-100');
            uploadModalContainer.classList.add('scale-95');
            setTimeout(() => {
                uploadModal.classList.add('hidden');
            }, 200);
        }

        function triggerFileBrowser() {
            document.getElementById('realFileInput').click();
        }

        function handleFileSelected(input) {
            if (input.files && input.files[0]) {
                let fileName = input.files[0].name;
                let fileTextSpan = document.getElementById('uploadedFileName');
                fileTextSpan.innerText = fileName;
                fileTextSpan.classList.remove('text-gray-400');
                fileTextSpan.classList.add('text-[#2D2D2D]', 'font-semibold');
                closeUploadModal();
            }
        }

        // Fungsi saat tombol Ajukan diklik (mencegah submit asli, memunculkan modal sukses)
        function handleFormSubmit(event) {
            event.preventDefault();
            successModal.classList.remove('hidden');
            setTimeout(() => {
                successModalContainer.classList.remove('scale-95');
                successModalContainer.classList.add('scale-100');
            }, 10);
        }

        // Fungsi tombol Tutup / Close pada modal sukses (mengarahkan ke halaman riwayat cuti)
        function redirectToHistory() {
            window.location.href = "{{ url('/leave/history') }}";
        }

        window.addEventListener('click', function(event) {
            if (event.target == uploadModal) {
                closeUploadModal();
            }
            if (event.target == successModal) {
                redirectToHistory();
            }
        });
    </script>

</body>
</html>