<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Ad;
use App\Jobs\CheckAdPrice;

class Kernel extends ConsoleKernel {
    protected function schedule(Schedule $schedule): void {
        $schedule->call(function () {
            Ad::withVerifiedSubscriptions()->orderBy('id')->chunkById(100, function ($ads) {
                foreach ($ads as $ad) { CheckAdPrice::dispatch($ad->id); }
            });
        })->everyTenMinutes()->withoutOverlapping()->name('dispatch-ad-checks');
    }
    protected function commands(): void {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
