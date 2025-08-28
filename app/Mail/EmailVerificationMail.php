<?php
namespace App\Mail;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class EmailVerificationMail extends Mailable {
    use Queueable, SerializesModels;
    public Subscription $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription) {
        $this->subscription = $subscription;
    }

    /**
     * @return EmailVerificationMail
     */
    public function build()
    {
        $verifyUrl = url('/api/verify?token=' . $this->subscription->verify_token);
        return $this->subject('Confirm your subscription')
            ->view('emails.verify', ['verifyUrl' => $verifyUrl]);
    }
}
