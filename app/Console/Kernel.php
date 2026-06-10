<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * Jalankan: php artisan schedule:work  (development)
     * Di server: tambahkan cron — * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
     */
    protected function schedule(Schedule $schedule): void
    {
        // Cek deadline & kirim notifikasi setiap jam
        $schedule->command('notifikasi:deadline')->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
