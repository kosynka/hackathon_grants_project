<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'offer_id',
        'admin_id',
        'rate_idea',
        'rate_realization',
        'rate_relevance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
