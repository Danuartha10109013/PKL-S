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
        Schema::table('jobcard_detail', function (Blueprint $table) {
            $table->bigInteger('qty')->change();
            $table->bigInteger('unit_bop')->change();
            $table->bigInteger('total_bop')->change();
            $table->bigInteger('unit_sp')->change();
            $table->bigInteger('total_sp')->change();
            $table->bigInteger('unit_bp')->change();
            $table->bigInteger('total_bp')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobcard_detail', function (Blueprint $table) {
            $table->integer('qty')->change();
            $table->integer('unit_bop')->change();
            $table->integer('total_bop')->change();
            $table->integer('unit_sp')->change();
            $table->integer('total_sp')->change();
            $table->integer('unit_bp')->change();
            $table->integer('total_bp')->change();
        });
    }
};
