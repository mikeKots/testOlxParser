<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Jobs\CheckAdPrice;
use Illuminate\Console\Command;

class UpdateAllAdPrices extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ads:update-prices';

    /**
     * @var string
     */
    protected $description = 'Перевіряє та оновлює ціни для всіх оголошень через чергу';

    /**
     * @return void
     */
    public function handle(): void
    {
        $ads = Ad::all();

        if ($ads->isEmpty()) {
            $this->info('Немає жодного оголошення для оновлення.');
            return;
        }

        foreach ($ads as $ad) {
            CheckAdPrice::dispatch($ad);
            $this->line("Оголошення #{$ad->id} додано в чергу.");
        }

        $this->info('Всі оголошення відправлені у чергу на перевірку.');
    }
}
