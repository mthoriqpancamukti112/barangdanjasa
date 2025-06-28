<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('name_metode', 200);
            $table->text('detail');
            $table->timestamps();
        });

        // Memasukkan data defaulnya biar tidak eror di sistemnya
        DB::table('metode_pembayaran')->insert([
            ['name_metode' => 'Cash on Delivery (COD)', 'detail' => 'Pembayaran langsung ke lokasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
