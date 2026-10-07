<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - WorkLeave</title>
    
    <!-- Google Fonts: Poppins & Montserrat Alternates -->
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
<body class="bg-white text-wl-black min-h-screen flex antialiased">

    <!-- Sidebar Navigation -->
    <aside id="appSidebar" class="w-72 bg-[#FFFBFB] border-r border-gray-100 flex flex-col justify-between py-8 px-5 fixed inset-y-0 left-0 z-50 transition-all duration-300 shadow-sm">
        <div>
            <!-- Brand Logo Header -->
            <div id="sidebarBrandContainer" class="flex items-center gap-3 px-2 mb-10 overflow-hidden transition-all">
                <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-9 w-auto object-contain shrink-0">
                <span class="sidebar-text text-xl font-bold tracking-tight text-[#9B0010] brand-font whitespace-nowrap">WorkLeave.com</span>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <a href="{{ url('/dashboard') }}"
                   class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3 rounded-2xl bg-[#C12132] text-white font-medium text-sm shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="sidebar-text whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ url('/leave/create') }}"
                   class="sidebar-menu-item flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#8C8C8C] group-hover:text-[#C12132]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="sidebar-text whitespace-nowrap">Ajukan Cuti</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="pt-6 border-t border-gray-100">
            <button id="sidebarToggleBtn" type="button" class="sidebar-menu-item w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <span class="sidebar-text whitespace-nowrap">Tutup Sidebar</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-white min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-white flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Script Toggle Sidebar -->
    <script>
        const sidebar = document.getElementById('appSidebar');
        const contentWrapper = document.getElementById('mainContentWrapper');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const menuItems = document.querySelectorAll('.sidebar-menu-item');
        const brandContainer = document.getElementById('sidebarBrandContainer');

        let isCollapsed = false;

        toggleBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            if (isCollapsed) {
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-20');
                contentWrapper.classList.remove('pl-72');
                contentWrapper.classList.add('pl-20');
                
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                brandContainer.classList.add('justify-center', 'px-0');
                menuItems.forEach(item => item.classList.add('justify-center', 'px-0'));
                toggleBtn.querySelector('svg').classList.add('rotate-180');
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-72');
                contentWrapper.classList.remove('pl-20');
                contentWrapper.classList.add('pl-72');

                sidebarTexts.forEach(el => el.classList.remove('hidden'));
                brandContainer.classList.remove('justify-center', 'px-0');
                menuItems.forEach(item => item.classList.remove('justify-center', 'px-0'));
                toggleBtn.querySelector('svg').classList.remove('rotate-180');
            }
        });
    </script>
</body>
</html>