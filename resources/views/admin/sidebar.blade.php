<!-- SIDEBAR NAVIGATION ADMIN -->
<aside id="appSidebar" class="w-72 bg-[#FFFBFB] border-r border-gray-100 flex flex-col justify-between py-8 px-5 fixed inset-y-0 left-0 z-50 transition-all duration-300 shadow-sm">
    <div>
        <!-- Brand Logo Header -->
        <div id="sidebarBrandContainer" class="flex items-center gap-3 px-2 mb-10 overflow-hidden transition-all">
            <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-9 w-auto object-contain shrink-0">
            <span class="sidebar-text text-xl font-bold tracking-tight text-[#9B0010] brand-font whitespace-nowrap">WorkLeave.com</span>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-3">
            <!-- Menu 1: Dashboard Admin -->
            <a href="{{ url('/admin/dashboard') }}"
               class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3.5 rounded-2xl {{ request()->is('admin/dashboard*') ? 'bg-[#C12132] text-white shadow-md shadow-red-500/20' : 'bg-[#F4D3D4]/40 text-[#C12132] hover:bg-[#F4D3D4]/70' }} font-semibold text-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Menu 2: Pengajuan Cuti / Persetujuan (Approvals) -->
            <a href="{{ url('/admin/approvals') }}"
               class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3.5 rounded-2xl {{ request()->is('admin/approvals*') ? 'bg-[#C12132] text-white shadow-md shadow-red-500/20' : 'bg-[#F4D3D4]/40 text-[#C12132] hover:bg-[#F4D3D4]/70' }} font-semibold text-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Pengajuan Cuti</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Footer / Collapse Button -->
    <div class="pt-6 border-t border-gray-100">
        <button id="sidebarToggleBtn" type="button" class="sidebar-menu-item w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
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
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const brandContainer = document.getElementById('sidebarBrandContainer');

        let isCollapsed = false;

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                isCollapsed = !isCollapsed;
                if (isCollapsed) {
                    sidebar.classList.remove('w-72');
                    sidebar.classList.add('w-20');
                    if (contentWrapper) {
                        contentWrapper.classList.remove('pl-72');
                        contentWrapper.classList.add('pl-20');
                    }
                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                    toggleBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    `;
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-72');
                    if (contentWrapper) {
                        contentWrapper.classList.remove('pl-20');
                        contentWrapper.classList.add('pl-72');
                    }
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                    toggleBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Tutup Sidebar</span>
                    `;
                }
            });
        }
    });
</script>
