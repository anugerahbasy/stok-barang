<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = ['supplier_code', 'company_name', 'pic_name', 'phone', 'address'];

    // Relasi: Satu supplier bisa memasok banyak jenis produk
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}