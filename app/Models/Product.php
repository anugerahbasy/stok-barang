<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'supplier_id', 'sku', 'name', 
        'alert_threshold', 'quantity_in_stock', 'cost_price', 'selling_price'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi: Satu produk punya banyak catatan naik-turun stok
    public function mutations(): HasMany
    {
        return $this->hasMany(StockMutation::class);
    }
}
