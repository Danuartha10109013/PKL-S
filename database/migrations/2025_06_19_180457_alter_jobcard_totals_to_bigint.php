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
        Schema::table('jobcard', function (Blueprint $table) {
            $table->bigInteger('totalbop')->change();
            $table->bigInteger('totalsp')->change();
            $table->bigInteger('totalbp')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobcard', function (Blueprint $table) {
            $table->integer('totalbop')->change();
            $table->integer('totalsp')->change();
            $table->integer('totalbp')->change();
        });
    }
};
