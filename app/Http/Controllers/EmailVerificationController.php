<?php
namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller {

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse {
        $request->validate(['token'=>'required']);
        $sub = Subscription::where('verify_token', $request->query('token'))->first();
        if (!$sub) { return response()->json(['message'=>'Invalid token'], 422); }
        $sub->verified_at = now();
        $sub->verify_token = null;
        $sub->save();
        return response()->json(['message'=>'Email verified. You will be notified on price changes.']);
    }
}
