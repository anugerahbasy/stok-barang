<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        $table->string('sku')->unique(); // Barcode / Kode unik barang
        $table->string('name');
        $table->integer('alert_threshold')->default(5); // Batas minimal stok untuk alert grafik dashboard
        $table->integer('quantity_in_stock')->default(0);
        $table->decimal('cost_price', 12, 2); // Harga modal (Desimal presisi tinggi)
        $table->decimal('selling_price', 12, 2); // Harga jual
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
