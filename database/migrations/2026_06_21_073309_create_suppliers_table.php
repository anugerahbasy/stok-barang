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
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('supplier_code')->unique(); // Unik: Kode internal (contoh: SPL-001)
        $table->string('company_name');
        $table->string('pic_name'); // Nama Penanggung Jawab
        $table->string('phone', 15);
        $table->text('address');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
