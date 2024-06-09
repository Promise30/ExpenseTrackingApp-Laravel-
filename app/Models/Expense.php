<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'quantity',
        'unit_price',
        'category',
        'receipt',
        'user_id',
        'status'
    ];
    public function getTotalCostAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
