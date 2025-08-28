<?php
namespace App\Http\Controllers;
use App\Jobs\CheckAdPrice;
use App\Models\Ad;
use App\Models\Subscription;
use App\Mail\EmailVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller {

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse {
        $data = $request->validate(['url'=>['required','url'],'email'=>['required','email']]);
        $ad = Ad::firstOrCreate(['url' => $data['url']]);
        $subscription = Subscription::firstOrNew(['ad_id'=>$ad->id,'email'=>$data['email']]);
        CheckAdPrice::dispatch($ad);

        if ($subscription->exists && $subscription->isVerified()) {
            return response()->json(['message'=>'Already subscribed and verified.'], 200);
        }
        $subscription->verify_token = Str::uuid()->toString();
        $subscription->verified_at = null;
        $subscription->save();
        Mail::to($subscription->email)->send(new EmailVerificationMail($subscription));
        return response()->json([
            'message' => 'Verification email sent. Please check your inbox.',
            'verify_token' => $subscription->verify_token
        ], 202);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse {
        $request->validate(['email'=>['required','email']]);
        $subs = Subscription::with('ad:id,url,last_price')
            ->where('email', $request->query('email'))
            ->get(['id','ad_id','email','verified_at','created_at']);
        return response()->json($subs);
    }
}
