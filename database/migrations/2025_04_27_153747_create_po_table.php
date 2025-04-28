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
        Schema::create('po', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po');
            $table->date('tanggal_penawaran');
            $table->string('nama_customer');
            $table->json('product');
            $table->string('no_penawaran');
            $table->string('status_penawaran');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_terima_po');
            $table->float('harga_ditawarkan');
            $table->float('harga_disetujui');
            $table->string('catatan')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po');
    }
};
