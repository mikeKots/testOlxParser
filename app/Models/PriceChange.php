<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PriceChange extends Model {
    use HasFactory;
    protected $fillable = ['ad_id','old_price','new_price'];
    public function ad(){ return $this->belongsTo(Ad::class); }
}
