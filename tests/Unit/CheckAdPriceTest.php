<?php
namespace Tests\Unit;
use App\Jobs\CheckAdPrice;
use App\Mail\PriceChangedMail;
use App\Models\Ad;
use App\Models\Subscription;
use App\Services\PriceFetcher;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class CheckAdPriceTest extends TestCase {
    public function test_notifies_on_price_change(): void {
        Mail::fake();
        $ad = Ad::create(['url'=>'https://example.com/ad1','last_price'=>100]);
        Subscription::create(['ad_id'=>$ad->id,'email'=>'user@example.com','verified_at'=>now()]);
        $fetcher = $this->createMock(PriceFetcher::class);
        $fetcher->method('fetch')->willReturn(90.0);
        $job = new CheckAdPrice($ad->id);
        $job->handle($fetcher);
        Mail::assertQueued(PriceChangedMail::class);
    }
}
