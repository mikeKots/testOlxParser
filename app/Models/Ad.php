<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model {
    use HasFactory;
    protected $fillable = ['url','last_price','last_checked_at'];

    /**
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeWithVerifiedSubscriptions($q): mixed
    {
        return $q->whereHas('subscriptions', fn($qq)=>$qq->whereNotNull('verified_at'));
    }
}
