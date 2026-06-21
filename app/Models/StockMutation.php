<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMutation extends Model
{
    protected $fillable = ['product_id', 'user_id', 'activity_type', 'amount', 'description'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Mengetahui staff/user mana yang melakukan input data
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}