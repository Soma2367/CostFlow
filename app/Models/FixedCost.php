<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FixedCostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedCost extends Model
{
    use HasFactory;

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
        'category' => Category::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
