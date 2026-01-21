<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\FixedCostStatus;

class FixedCost extends Model
{
    protected $fillable = [
        'user_id',
        'cost_name',
        'category',
        'amount',
        'billing_day',
        'status',
        'memo',
    ];

    public $casts = [
        'status' => FixedCostStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
