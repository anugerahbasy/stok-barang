<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    // Tambahkan 'user_id' di sini agar bisa disimpan ke database
    protected $fillable = [
        'supplier_code', 
        'company_name', 
        'pic_name', 
        'phone', 
        'address', 
        'user_id' 
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}