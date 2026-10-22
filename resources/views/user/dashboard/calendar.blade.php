<div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] space-y-4">
    <!-- Header Kalender -->
    <div class="flex items-center justify-between pb-1">
        <div>
            <h2 id="calMonthTitle" class="text-base font-bold text-[#2D2D2D]">Oktober 2026</h2>
            <p class="text-[11px] text-[#8C8C8C] mt-0.5">Pantau hari kerja, tanggal merah & weekend</p>
        </div>
        <div class="flex items-center gap-1.5 bg-[#F8FAFC] border border-gray-200 rounded-xl px-2 py-1">
            <button id="calPrev" type="button" class="p-1 text-gray-600 hover:text-[#C12132] cursor-pointer" title="Bulan Sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            </button>
            <button id="calNext" type="button" class="p-1 text-gray-600 hover:text-[#C12132] cursor-pointer" title="Bulan Berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </button>
        </div>
    </div>

    <!-- Header Nama Hari (Senin s/d Minggu) -->
    <div class="grid grid-cols-7 text-center pb-2 text-[11px] font-semibold text-[#5D5D5D]">
        <div>Sen</div>
        <div>Sel</div>
        <div>Rab</div>
        <div>Kam</div>
        <div>Jum</div>
        <div class="text-amber-600 font-bold">Sab</div>
        <div class="text-rose-600 font-bold">Min</div>
    </div>

    <!-- Grid Tanggal -->
    <div id="calendarDaysGrid" class="grid grid-cols-7 border-t border-l border-gray-100 rounded-xl overflow-hidden text-xs bg-white">
        <!-- Render otomatis via JavaScript -->
    </div>

    <!-- LEGENDA WARNA TANGGAL -->
    <div class="pt-2 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2 text-[11px] text-[#5D5D5D]">
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-md bg-[#FDE8EC] border border-red-200 inline-block"></span>
            <span>Libur Nasional</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-md bg-amber-50 border border-amber-200 inline-block"></span>
            <span>Sabtu</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-md bg-rose-50 border border-rose-200 inline-block"></span>
            <span>Minggu</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-md bg-blue-50 border border-blue-500 inline-block"></span>
            <span>Hari Ini</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        let currYear = now.getFullYear();
        let currMonth = now.getMonth();

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // ============================================================
        // MESIN PREDIKSI LIBUR NASIONAL INDONESIA (GOOGLE CALENDAR STYLE)
        // ============================================================
        const FIXED_HOLIDAYS_INDO = {
            '01-01': 'Tahun Baru Masehi',
            '05-01': 'Hari Buruh Internasional',
            '06-01': 'Hari Lahir Pancasila',
            '08-17': 'Hari Kemerdekaan Republik Indonesia',
            '12-25': 'Hari Raya Natal',
        };

        const MULTI_YEAR_LUNAR_HOLIDAYS = {
            // Tahun 2025
            '2025-01-27': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2025-01-29': 'Tahun Baru Imlek 2576 Kongzili',
            '2025-03-29': 'Hari Suci Nyepi Saka 1947',
            '2025-03-31': 'Hari Raya Idul Fitri 1446 H',
            '2025-04-01': 'Hari Raya Idul Fitri 1446 H',
            '2025-05-12': 'Hari Raya Waisak 2569 BE',
            '2025-06-06': 'Hari Raya Idul Adha 1446 H',
            '2025-06-27': 'Tahun Baru Islam 1447 Hijriah',
            '2025-09-05': 'Maulid Nabi Muhammad SAW',

            // Tahun 2026
            '2026-01-28': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2026-02-17': 'Tahun Baru Imlek 2577 Kongzili',
            '2026-03-20': 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21': 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21': 'Hari Suci Nyepi Saka 1948',
            '2026-05-27': 'Hari Raya Idul Adha 1447 H',
            '2026-05-31': 'Hari Raya Waisak 2570 BE',
            '2026-06-16': 'Tahun Baru Islam 1448 Hijriah',
            '2026-08-25': 'Maulid Nabi Muhammad SAW',

            // Tahun 2027
            '2027-01-16': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2027-02-06': 'Tahun Baru Imlek 2578 Kongzili',
            '2027-03-09': 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10': 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10': 'Hari Suci Nyepi Saka 1949',
            '2027-05-16': 'Hari Raya Idul Adha 1448 H',
            '2027-05-20': 'Hari Raya Waisak 2571 BE',
            '2027-06-06': 'Tahun Baru Islam 1449 Hijriah',
            '2027-08-15': 'Maulid Nabi Muhammad SAW',

            // Tahun 2028
            '2028-01-05': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2028-01-26': 'Tahun Baru Imlek 2579 Kongzili',
            '2028-02-27': 'Hari Raya Idul Fitri 1449 H',
            '2028-02-28': 'Hari Raya Idul Fitri 1449 H',
            '2028-03-27': 'Hari Suci Nyepi Saka 1950',
            '2028-05-05': 'Hari Raya Idul Adha 1449 H',
            '2028-05-09': 'Hari Raya Waisak 2572 BE',
            '2028-05-26': 'Tahun Baru Islam 1450 Hijriah',
            '2028-08-04': 'Maulid Nabi Muhammad SAW',
            '2028-12-24': 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2029
            '2029-02-13': 'Tahun Baru Imlek 2580 Kongzili',
            '2029-02-15': 'Hari Raya Idul Fitri 1450 H',
            '2029-02-16': 'Hari Raya Idul Fitri 1450 H',
            '2029-03-15': 'Hari Suci Nyepi Saka 1951',
            '2029-04-24': 'Hari Raya Idul Adha 1450 H',
            '2029-05-15': 'Tahun Baru Islam 1451 Hijriah',
            '2029-05-27': 'Hari Raya Waisak 2573 BE',
            '2029-07-24': 'Maulid Nabi Muhammad SAW',
            '2029-12-14': 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2030
            '2030-02-03': 'Tahun Baru Imlek 2581 Kongzili',
            '2030-02-05': 'Hari Raya Idul Fitri 1451 H',
            '2030-02-06': 'Hari Raya Idul Fitri 1451 H',
            '2030-03-05': 'Hari Suci Nyepi Saka 1952',
            '2030-04-14': 'Hari Raya Idul Adha 1451 H',
            '2030-05-04': 'Tahun Baru Islam 1452 Hijriah',
            '2030-05-16': 'Hari Raya Waisak 2574 BE',
            '2030-07-13': 'Maulid Nabi Muhammad SAW',
            '2030-12-03': 'Isra Mi\'raj Nabi Muhammad SAW',
        };

        // Algoritma Computus Astronomis untuk Hari Paskah, Wafat Yesus Kristus & Kenaikan
        function getComputusHolidays(year) {
            const a = year % 19;
            const b = Math.floor(year / 100);
            const c = year % 100;
            const d = Math.floor(b / 4);
            const e = b % 4;
            const f = Math.floor((b + 8) / 25);
            const g = Math.floor((b - f + 1) / 3);
            const h = (19 * a + b - d - g + 15) % 30;
            const i = Math.floor(c / 4);
            const k = c % 4;
            const l = (32 + 2 * e + 2 * i - h - k) % 7;
            const m = Math.floor((a + 11 * h + 22 * l) / 451);
            const month = Math.floor((h + l - 7 * m + 114) / 31);
            const day = ((h + l - 7 * m + 114) % 31) + 1;

            const easterDate = new Date(year, month - 1, day);
            const goodFriday = new Date(easterDate);
            goodFriday.setDate(easterDate.getDate() - 2);
            const ascension = new Date(easterDate);
            ascension.setDate(easterDate.getDate() + 39);

            const format = (dt) => {
                const mm = String(dt.getMonth() + 1).padStart(2, '0');
                const dd = String(dt.getDate()).padStart(2, '0');
                return `${dt.getFullYear()}-${mm}-${dd}`;
            };

            const holidays = {};
            holidays[format(goodFriday)] = 'Wafat Yesus Kristus';
            holidays[format(easterDate)] = 'Hari Paskah';
            holidays[format(ascension)] = 'Kenaikan Yesus Kristus';
            return holidays;
        }

        function resolveIndonesianHoliday(dateKey, year, mStr, dStr) {
            const mmDd = `${mStr}-${dStr}`;
            if (FIXED_HOLIDAYS_INDO[mmDd]) {
                return FIXED_HOLIDAYS_INDO[mmDd];
            }
            if (MULTI_YEAR_LUNAR_HOLIDAYS[dateKey]) {
                return MULTI_YEAR_LUNAR_HOLIDAYS[dateKey];
            }
            const computus = getComputusHolidays(year);
            if (computus[dateKey]) {
                return computus[dateKey];
            }
            return null;
        }

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

            // Hari kosong dari bulan sebelumnya
            for (let i = startDay - 1; i >= 0; i--) {
                const dayNum = prevTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'h-16 p-1.5 border-r border-b border-gray-100 text-gray-300 bg-gray-50/40';
                cell.textContent = dayNum;
                gridEl.appendChild(cell);
                cellCount++;
            }

            // Hari pada bulan ini
            for (let d = 1; d <= totalDays; d++) {
                const cell = document.createElement('div');
                const dateObj = new Date(y, m, d);
                const dayOfWeek = dateObj.getDay(); // 0 = Minggu, 6 = Sabtu

                // Format key: YYYY-MM-DD
                const mStr = String(m + 1).padStart(2, '0');
                const dStr = String(d).padStart(2, '0');
                const dateKey = `${y}-${mStr}-${dStr}`;

                const holidayName = resolveIndonesianHoliday(dateKey, y, mStr, dStr);
                const isHoliday = !!holidayName;

                const isSunday = (dayOfWeek === 0);
                const isSaturday = (dayOfWeek === 6);
                const isWeekend = isSunday || isSaturday;
                const isToday = isTodayThisMonth && d === today.getDate();

                let cellClass = 'h-16 p-1.5 border-r border-b border-gray-100 flex flex-col justify-between transition-colors relative group ';

                // Logika Pewarnaan Tanggal
                if (isHoliday) {
                    // Merah Libur Nasional
                    cellClass += 'bg-[#FDE8EC] text-[#C12132] font-bold border-red-200 ';
                } else if (isToday) {
                    // Highlight Hari Ini (Warna Biru)
                    cellClass += 'bg-blue-50/70 text-blue-600 font-bold ring-2 ring-blue-500 ring-inset ';
                } else if (isSunday) {
                    // Minggu: Merah Muda
                    cellClass += 'bg-rose-50/50 text-rose-600 font-semibold ';
                } else if (isSaturday) {
                    // Sabtu: Oranye/Kuning Muda
                    cellClass += 'bg-amber-50/40 text-amber-600 font-semibold ';
                } else {
                    // Hari Kerja Biasa
                    cellClass += 'text-[#2D2D2D] hover:bg-gray-50 ';
                }

                cell.className = cellClass;
                cell.setAttribute('title', isHoliday ? `Libur Nasional: ${holidayName}` : (isToday ? 'Hari Ini' : (isSunday ? 'Hari Minggu' : (isSaturday ? 'Hari Sabtu' : 'Hari Kerja'))));

                // Isi Cell
                let innerContent = `
                    <div class="flex items-center justify-between">
                        <span class="${isHoliday ? 'text-xs font-bold' : ''}">${d}</span>
                        ${isHoliday ? '<span class="w-1.5 h-1.5 rounded-full bg-[#C12132] shrink-0"></span>' : ''}
                    </div>
                `;

                if (isHoliday) {
                    innerContent += `
                        <span class="text-[9px] leading-tight text-[#C12132] truncate font-semibold block mt-auto" title="${holidayName}">
                            ${holidayName}
                        </span>
                    `;
                } else if (isToday) {
                    innerContent += `
                        <span class="text-[9px] leading-tight text-blue-600 font-semibold block mt-auto">
                            Hari Ini
                        </span>
                    `;
                }

                cell.innerHTML = innerContent;
                gridEl.appendChild(cell);
                cellCount++;
            }

            // Sisa hari dari bulan berikutnya
            let remainingCells = (cellCount % 7 === 0) ? 0 : (7 - (cellCount % 7));
            for (let n = 1; n <= remainingCells; n++) {
                const cell = document.createElement('div');
                cell.className = 'h-16 p-1.5 border-r border-b border-gray-100 text-gray-300 bg-gray-50/40';
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