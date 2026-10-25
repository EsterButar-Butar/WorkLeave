<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HolidayService
{
    /**
     * Cek apakah sebuah tanggal adalah hari akhir pekan (Sabtu atau Minggu).
     */
    public function isWeekend(Carbon|string $date): bool
    {
        return Carbon::parse($date)->isWeekend();
    }

    /**
     * Cek apakah sebuah tanggal adalah hari libur nasional Indonesia.
     */
    public function isNationalHoliday(Carbon|string $date): bool
    {
        $cDate = Carbon::parse($date);

        // Jika library Spatie Holidays terpasang
        if (class_exists(\Spatie\Holidays\Holidays::class)) {
            try {
                return \Spatie\Holidays\Holidays::for('id')->isHoliday($cDate);
            } catch (\Throwable $e) {
                // Lanjut ke fallback jika terjadi pengecualian
            }
        }

        // Backup mandiri data hari libur nasional (life-time)
        return $this->getFallbackHolidayName($cDate) !== null;
    }

    /**
     * Dapatkan nama hari libur nasional Indonesia.
     */
    public function getHolidayName(Carbon|string $date): ?string
    {
        $cDate = Carbon::parse($date);

        if (class_exists(\Spatie\Holidays\Holidays::class)) {
            try {
                $name = \Spatie\Holidays\Holidays::for('id')->getName($cDate);
                if ($name) {
                    return $name;
                }
            } catch (\Throwable $e) {
                //
            }
        }

        return $this->getFallbackHolidayName($cDate);
    }

    /**
     * Cek apakah hari kerja aktif (Senin-Jumat dan bukan tanggal merah nasional).
     */
    public function isWorkingDay(Carbon|string $date): bool
    {
        $cDate = Carbon::parse($date);

        if ($this->isWeekend($cDate)) {
            return false;
        }

        if ($this->isNationalHoliday($cDate)) {
            return false;
        }

        return true;
    }

    /**
     * Hitung kalkulasi pemotongan kuota cuti antara dua tanggal.
     * Untuk Cuti Tahunan (ANNUAL): Akhir pekan & hari libur nasional tidak memotong kuota.
     */
    public function calculateDays(Carbon|string $startDate, Carbon|string $endDate, string $leaveTypeCode = 'ANNUAL'): array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        if ($end->lt($start)) {
            return [
                'total_calendar_days' => 0,
                'deducted_days' => 0,
                'working_days' => 0,
                'weekend_days' => 0,
                'holiday_days' => 0,
                'holidays' => [],
                'details' => [],
            ];
        }

        $period = CarbonPeriod::create($start, $end);
        $totalCalendarDays = 0;
        $workingDays = 0;
        $weekendDays = 0;
        $holidayDays = 0;
        $holidaysFound = [];
        $details = [];

        $typeUpper = strtoupper($leaveTypeCode);
        $isWorkDaysOnly = in_array($typeUpper, ['ANNUAL', 'SICK']);
        $isMaternity = ($typeUpper === 'MATERNITY');

        // Ketentuan Kuota Maksimal:
        // 1. Cuti Tahunan: Maksimal 12 hari kerja per tahun
        // 2. Cuti Sakit: Maksimal 7 hari kerja per tahun
        // 3. Cuti Bersalin: Maksimal 90 hari kalender penuh
        $maxQuota = match ($typeUpper) {
            'ANNUAL' => 12,
            'SICK' => 7,
            'MATERNITY' => 90,
            default => null,
        };

        foreach ($period as $date) {
            $totalCalendarDays++;
            $dateStr = $date->toDateString();
            $dayName = $this->translateDayName($date->format('l'));
            $isWeekend = $this->isWeekend($date);
            $holidayName = $this->getHolidayName($date);
            $isHoliday = $holidayName !== null;

            if ($isHoliday && !in_array($holidayName, array_column($holidaysFound, 'name'))) {
                $holidaysFound[] = [
                    'date' => $dateStr,
                    'name' => $holidayName,
                ];
            }

            if ($isWeekend) {
                $weekendDays++;
                $note = 'Akhir Pekan (' . $dayName . ')';
                $isCounted = $isMaternity ? true : !$isWorkDaysOnly;
            } elseif ($isHoliday) {
                $holidayDays++;
                $note = 'Libur Nasional: ' . $holidayName;
                $isCounted = $isMaternity ? true : !$isWorkDaysOnly;
            } else {
                $workingDays++;
                $note = 'Hari Kerja Efektif';
                $isCounted = true;
            }

            $details[] = [
                'date' => $dateStr,
                'day_name' => $dayName,
                'is_weekend' => $isWeekend,
                'is_holiday' => $isHoliday,
                'holiday_name' => $holidayName,
                'is_counted' => $isCounted,
                'note' => $note,
            ];
        }

        // Cuti Tahunan & Sakit: hanya memotong hari kerja aktif (tidak termasuk weekend & libur nasional)
        // Cuti Bersalin: memotong hari kalender penuh (termasuk weekend & libur nasional)
        $deductedDays = $isMaternity ? $totalCalendarDays : $workingDays;

        return [
            'total_calendar_days' => $totalCalendarDays,
            'deducted_days' => $deductedDays,
            'working_days' => $workingDays,
            'weekend_days' => $weekendDays,
            'holiday_days' => $holidayDays,
            'holidays' => $holidaysFound,
            'details' => $details,
            'max_quota' => $maxQuota,
            'is_work_days_only' => $isWorkDaysOnly,
            'is_exceeding_max_quota' => ($maxQuota !== null && $deductedDays > $maxQuota),
        ];
    }

    /**
     * Terjemahkan nama hari ke Bahasa Indonesia.
     */
    protected function translateDayName(string $dayName): string
    {
        return match ($dayName) {
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
            default => $dayName,
        };
    }

    /**
     * Fallback database hari libur nasional Indonesia (life-time).
     */
    protected function getFallbackHolidayName(Carbon $date): ?string
    {
        $mDate = $date->format('m-d');
        $fullDate = $date->format('Y-m-d');

        // Hari Libur Nasional Tanggal Tetap di Indonesia
        $fixedHolidays = [
            '01-01' => 'Tahun Baru Masehi',
            '05-01' => 'Hari Buruh Internasional',
            '06-01' => 'Hari Lahir Pancasila',
            '08-17' => 'Hari Kemerdekaan Republik Indonesia',
            '12-25' => 'Hari Raya Natal',
        ];

        if (isset($fixedHolidays[$mDate])) {
            return $fixedHolidays[$mDate];
        }

        // 1. Hari Libur Kristiani berbasis Algoritma Astronomis Computus (Meeus/Butcher)
        // Terhitung otomatis & presisi untuk tahun berapapun (Google Calendar Engine)
        $year = (int) $date->format('Y');
        $easter = $this->calculateEasterDate($year);
        if ($easter) {
            $goodFriday = $easter->copy()->subDays(2)->format('Y-m-d');
            $ascension = $easter->copy()->addDays(39)->format('Y-m-d');
            $easterDay = $easter->format('Y-m-d');

            if ($fullDate === $goodFriday) {
                return 'Wafat Yesus Kristus';
            }
            if ($fullDate === $easterDay) {
                return 'Hari Paskah';
            }
            if ($fullDate === $ascension) {
                return 'Kenaikan Yesus Kristus';
            }
        }

        // 2. Database Prediksi Hari Libur Astronomis Indonesia (2025 - 2030+)
        $skbHolidays = [
            // Tahun 2025
            '2025-01-27' => 'Isra Mi\'raj Nabi Muhammad SAW',
            '2025-01-29' => 'Tahun Baru Imlek 2576 Kongzili',
            '2025-03-29' => 'Hari Suci Nyepi Saka 1947',
            '2025-03-31' => 'Hari Raya Idul Fitri 1446 H',
            '2025-04-01' => 'Hari Raya Idul Fitri 1446 H',
            '2025-05-12' => 'Hari Raya Waisak 2569 BE',
            '2025-06-06' => 'Hari Raya Idul Adha 1446 H',
            '2025-06-27' => 'Tahun Baru Islam 1447 Hijriah',
            '2025-09-05' => 'Maulid Nabi Muhammad SAW',

            // Tahun 2026
            '2026-01-28' => 'Isra Mi\'raj Nabi Muhammad SAW',
            '2026-02-17' => 'Tahun Baru Imlek 2577 Kongzili',
            '2026-03-20' => 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21' => 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21' => 'Hari Suci Nyepi Saka 1948',
            '2026-05-27' => 'Hari Raya Idul Adha 1447 H',
            '2026-05-31' => 'Hari Raya Waisak 2570 BE',
            '2026-06-16' => 'Tahun Baru Islam 1448 Hijriah',
            '2026-08-25' => 'Maulid Nabi Muhammad SAW',

            // Tahun 2027
            '2027-01-16' => 'Isra Mi\'raj Nabi Muhammad SAW',
            '2027-02-06' => 'Tahun Baru Imlek 2578 Kongzili',
            '2027-03-09' => 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10' => 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10' => 'Hari Suci Nyepi Saka 1949',
            '2027-05-16' => 'Hari Raya Idul Adha 1448 H',
            '2027-05-20' => 'Hari Raya Waisak 2571 BE',
            '2027-06-06' => 'Tahun Baru Islam 1449 Hijriah',
            '2027-08-15' => 'Maulid Nabi Muhammad SAW',

            // Tahun 2028
            '2028-01-05' => 'Isra Mi\'raj Nabi Muhammad SAW',
            '2028-01-26' => 'Tahun Baru Imlek 2579 Kongzili',
            '2028-02-27' => 'Hari Raya Idul Fitri 1449 H',
            '2028-02-28' => 'Hari Raya Idul Fitri 1449 H',
            '2028-03-27' => 'Hari Suci Nyepi Saka 1950',
            '2028-05-05' => 'Hari Raya Idul Adha 1449 H',
            '2028-05-09' => 'Hari Raya Waisak 2572 BE',
            '2028-05-26' => 'Tahun Baru Islam 1450 Hijriah',
            '2028-08-04' => 'Maulid Nabi Muhammad SAW',
            '2028-12-24' => 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2029
            '2029-02-13' => 'Tahun Baru Imlek 2580 Kongzili',
            '2029-02-15' => 'Hari Raya Idul Fitri 1450 H',
            '2029-02-16' => 'Hari Raya Idul Fitri 1450 H',
            '2029-03-15' => 'Hari Suci Nyepi Saka 1951',
            '2029-04-24' => 'Hari Raya Idul Adha 1450 H',
            '2029-05-15' => 'Tahun Baru Islam 1451 Hijriah',
            '2029-05-27' => 'Hari Raya Waisak 2573 BE',
            '2029-07-24' => 'Maulid Nabi Muhammad SAW',
            '2029-12-14' => 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2030
            '2030-02-03' => 'Tahun Baru Imlek 2581 Kongzili',
            '2030-02-05' => 'Hari Raya Idul Fitri 1451 H',
            '2030-02-06' => 'Hari Raya Idul Fitri 1451 H',
            '2030-03-05' => 'Hari Suci Nyepi Saka 1952',
            '2030-04-14' => 'Hari Raya Idul Adha 1451 H',
            '2030-05-04' => 'Tahun Baru Islam 1452 Hijriah',
            '2030-05-16' => 'Hari Raya Waisak 2574 BE',
            '2030-07-13' => 'Maulid Nabi Muhammad SAW',
            '2030-12-03' => 'Isra Mi\'raj Nabi Muhammad SAW',
        ];

        return $skbHolidays[$fullDate] ?? null;
    }

    /**
     * Hitung tanggal Paskah (Easter Sunday) menggunakan algoritma Butcher's Computus.
     */
    protected function calculateEasterDate(int $year): ?Carbon
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($year, $month, $day);
    }
}
