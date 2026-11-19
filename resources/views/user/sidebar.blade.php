
<!-- SIDEBAR NAVIGATION USER -->
<aside id="appSidebar"
    class="w-72 bg-[#FFFBFB] border-r border-gray-100 flex flex-col justify-between py-8 px-5 fixed inset-y-0 left-0 z-50 transition-all duration-300 ease-in-out shadow-sm">

    <div>
        <!-- Brand Logo Header -->
        <div id="sidebarBrandContainer"
            class="flex items-center gap-3 px-2 mb-10 overflow-hidden transition-all duration-300">
            <img src="{{ asset('img/logo.png') }}" alt="WorkLeave"
                class="h-9 w-auto object-contain shrink-0">

            <span class="sidebar-text text-xl font-bold tracking-tight text-[#9B0010] brand-font whitespace-nowrap">
                WorkLeave.com
            </span>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-3">
            <a href="{{ url('/dashboard') }}"
                class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3.5 rounded-2xl
                {{ request()->is('dashboard*') ? 'bg-[#C12132] text-white shadow-md shadow-red-500/20' : 'bg-[#F4D3D4]/40 text-[#C12132] hover:bg-[#F4D3D4]/70' }}
                font-semibold text-sm transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ url('/leave/create') }}"
                class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3.5 rounded-2xl
                {{ request()->is('leave/create*') ? 'bg-[#C12132] text-white shadow-md shadow-red-500/20' : 'bg-[#F4D3D4]/40 text-[#C12132] hover:bg-[#F4D3D4]/70' }}
                font-semibold text-sm transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Ajukan Cuti</span>
            </a>

            <a href="{{ route('leave.history') }}"
                class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3.5 rounded-2xl
                {{ request()->is('leave/history*') ? 'bg-[#C12132] text-white shadow-md shadow-red-500/20' : 'bg-[#F4D3D4]/40 text-[#C12132] hover:bg-[#F4D3D4]/70' }}
                font-semibold text-sm transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Riwayat Cuti</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="pt-6 border-t border-gray-100">
        <button id="sidebarToggleBtn" type="button"
            class="sidebar-menu-item w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 shrink-0 transition-transform duration-300"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <span class="sidebar-text whitespace-nowrap">Tutup Sidebar</span>
        </button>
    </div>
</aside>

<!-- SCRIPT TOGGLE SIDEBAR -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('appSidebar');
        const contentWrapper = document.getElementById('mainContentWrapper');
        const toggleBtn = document.getElementById('sidebarToggleBtn');

        if (!sidebar || !toggleBtn) return;

        const sidebarTexts = sidebar.querySelectorAll('.sidebar-text');
        const menuItems = sidebar.querySelectorAll('.sidebar-menu-item');
        const brandContainer = document.getElementById('sidebarBrandContainer');
        const toggleIcon = toggleBtn.querySelector('svg');

        let isCollapsed = false;

        function updateSidebar() {
            const isMobile = window.innerWidth < 768;

            if (isCollapsed) {
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-20');

                sidebarTexts.forEach(element => {
                    element.classList.add('hidden');
                });

                if (brandContainer) {
                    brandContainer.classList.add('justify-center', 'px-0');
                }

                menuItems.forEach(item => {
                    item.classList.add('justify-center', 'px-0');
                });

                if (toggleIcon) {
                    toggleIcon.classList.add('rotate-180');
                }
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-72');

                sidebarTexts.forEach(element => {
                    element.classList.remove('hidden');
                });

                if (brandContainer) {
                    brandContainer.classList.remove('justify-center', 'px-0');
                }

                menuItems.forEach(item => {
                    item.classList.remove('justify-center', 'px-0');
                });

                if (toggleIcon) {
                    toggleIcon.classList.remove('rotate-180');
                }
            }

            // Sesuaikan jarak konten utama dengan lebar sidebar.
            if (contentWrapper) {
                contentWrapper.classList.remove('pl-72', 'pl-20', 'pl-0');

                if (isMobile) {
                    contentWrapper.classList.add('pl-0');
                } else if (isCollapsed) {
                    contentWrapper.classList.add('pl-20');
                } else {
                    contentWrapper.classList.add('pl-72');
                }
            }
        }

        toggleBtn.addEventListener('click', function () {
            isCollapsed = !isCollapsed;
            updateSidebar();
        });

        // Sesuaikan kembali layout ketika ukuran layar berubah.
        window.addEventListener('resize', updateSidebar);

        // Terapkan kondisi awal.
        updateSidebar();
    });
</script>
