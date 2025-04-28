<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifTable extends Migration
{
    public function up(): void
    {
        Schema::create('notif', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('judul');
            $table->string('no_jobcard');
            $table->string('jumlah_pengadaan');
            $table->string('user_id');
            $table->integer('status')->default(0);
            $table->integer('important')->nullable();
            $table->string('material_id')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notif');
    }
}
