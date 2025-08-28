<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Services\PriceFetcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckAdPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $adId;

    /**
     * @param Ad $ad
     */
    public function __construct(Ad $ad)
    {
        $this->adId = $ad->id;
    }

    /**
     * @param PriceFetcher $parser
     * @return void
     */
    public function handle(PriceFetcher $parser): void
    {
        $ad = Ad::find($this->adId);

        if (!$ad) {
            return;
        }

        $html = @file_get_contents($ad->url);

        if (!$html) {
            return;
        }

        $price = $parser->fetchPrice($html);

        if ($price !== null) {
            $ad->last_price = $price;
            $ad->save();
        }
    }
}
