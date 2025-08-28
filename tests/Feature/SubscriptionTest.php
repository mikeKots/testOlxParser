<?php
namespace Tests\Feature;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\Ad;
use App\Models\Subscription;
use App\Mail\EmailVerificationMail;
class SubscriptionTest extends TestCase {
    public function test_subscribe_sends_verification_email(): void {
        Mail::fake();
        $this->postJson('/api/subscribe', ['url'=>'https://example.com/ad1','email'=>'user@example.com'])
            ->assertStatus(202);
        Mail::assertSent(EmailVerificationMail::class, 1);
    }
    public function test_verify_with_token(): void {
        $ad = Ad::create(['url'=>'https://example.com/ad1']);
        $sub = Subscription::create(['ad_id'=>$ad->id,'email'=>'user@example.com','verify_token'=>'tok123']);
        $this->getJson('/api/verify?token=tok123')->assertOk();
    }
}
