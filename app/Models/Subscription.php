<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscription extends Model {
    use HasFactory;
    protected $fillable = ['ad_id','email','verify_token','verified_at'];
    protected $casts = ['verified_at'=>'datetime'];
    public function ad(){ return $this->belongsTo(Ad::class); }
    public function isVerified(): bool { return !is_null($this->verified_at); }
}
