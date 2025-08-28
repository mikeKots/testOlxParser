<?php
namespace App\Mail;
use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class PriceChangedMail extends Mailable {
    use Queueable, SerializesModels;
    public Ad $ad; public ?float $oldPrice; public float $newPrice;

    /**
     * @param Ad $ad
     * @param float|null $oldPrice
     * @param float $newPrice
     */
    public function __construct(Ad $ad, ?float $oldPrice, float $newPrice)
    {
        $this->ad=$ad;
        $this->oldPrice=$oldPrice;
        $this->newPrice=$newPrice;
    }

    /**
     * @return PriceChangedMail
     */
    public function build(){
        return $this->subject('OLX price changed')->view('emails.price_changed',[
            'url'=>$this->ad->url ,'old'=>$this->oldPrice, 'new'=>$this->newPrice
        ]);
    }
}
