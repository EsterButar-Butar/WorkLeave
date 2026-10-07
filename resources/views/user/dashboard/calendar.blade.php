<div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] space-y-4">
    <div class="flex items-center justify-between pb-1">
        <h2 id="calMonthTitle" class="text-base font-bold text-[#2D2D2D]">Oct 2026</h2>
        <div class="flex items-center gap-1.5 bg-[#F8FAFC] border border-gray-200 rounded-xl px-2 py-1">
            <button id="calPrev" type="button" class="p-1 text-gray-600 hover:text-[#C12132]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            </button>
            <button id="calNext" type="button" class="p-1 text-gray-600 hover:text-[#C12132]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </button>
        </div>
    </div>

    <!-- Hari -->
    <div class="grid grid-cols-7 text-center pb-2 text-[11px] font-semibold text-[#5D5D5D]">
        <div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div><div>Su</div>
    </div>

    <!-- Grid Tanggal -->
    <div id="calendarDaysGrid" class="grid grid-cols-7 border-t border-l border-gray-100 rounded-xl overflow-hidden text-xs bg-white">
        <!-- Render otomatis via JavaScript -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        let currYear = now.getFullYear();
        let currMonth = now.getMonth();

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const titleEl = document.getElementById('calMonthTitle');
        const gridEl = document.getElementById('calendarDaysGrid');
        const prevBtn = document.getElementById('calPrev');
        const nextBtn = document.getElementById('calNext');

        function renderCalendar(y, m) {
            titleEl.textContent = `${monthNames[m]} ${y}`;
            gridEl.innerHTML = '';

            const firstDayIndex = new Date(y, m, 1).getDay();
            let startDay = firstDayIndex - 1;
            if (startDay < 0) startDay = 6;

            const totalDays = new Date(y, m + 1, 0).getDate();
            const prevTotalDays = new Date(y, m, 0).getDate();

            const today = new Date();
            const isTodayThisMonth = (today.getFullYear() === y && today.getMonth() === m);

            let cellCount = 0;

            for (let i = startDay - 1; i >= 0; i--) {
                const dayNum = prevTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'h-16 p-1.5 border-r border-b border-gray-100 text-gray-300';
                cell.textContent = dayNum;
                gridEl.appendChild(cell);
                cellCount++;
            }

            for (let d = 1; d <= totalDays; d++) {
                const cell = document.createElement('div');
                let cellClass = 'h-16 p-1.5 border-r border-b border-gray-100 flex flex-col justify-between ';

                if (y === 2026 && m === 9 && (d === 18 || d === 19)) {
                    cellClass += 'bg-[#FCD3D4] text-[#9B0010] font-semibold ';
                } else if (isTodayThisMonth && d === today.getDate()) {
                    cellClass += 'bg-[#FFF5F6] text-[#C12132] font-bold ring-1 ring-[#C12132] ';
                } else {
                    cellClass += 'text-[#2D2D2D] ';
                }

                cell.className = cellClass;
                cell.innerHTML = `<span>${d}</span>`;
                gridEl.appendChild(cell);
                cellCount++;
            }

            let remainingCells = (cellCount % 7 === 0) ? 0 : (7 - (cellCount % 7));
            for (let n = 1; n <= remainingCells; n++) {
                const cell = document.createElement('div');
                cell.className = 'h-16 p-1.5 border-r border-b border-gray-100 text-gray-300';
                cell.textContent = n;
                gridEl.appendChild(cell);
            }
        }

        renderCalendar(currYear, currMonth);

        prevBtn.addEventListener('click', () => {
            currMonth--;
            if (currMonth < 0) {
                currMonth = 11;
                currYear--;
            }
            renderCalendar(currYear, currMonth);
        });

        nextBtn.addEventListener('click', () => {
            currMonth++;
            if (currMonth > 11) {
                currMonth = 0;
                currYear++;
            }
            renderCalendar(currYear, currMonth);
        });
    });
</script>