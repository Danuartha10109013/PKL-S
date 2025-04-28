<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobcardDetailTable extends Migration
{
    public function up(): void
    {
        Schema::create('jobcard_detail', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('jobcard_id'); // jobcard_id BIGINT UNSIGNED
            $table->integer('qty');
            $table->string('description');
            $table->integer('unit_bop');
            $table->integer('total_bop');
            $table->integer('unit_sp');
            $table->integer('total_sp');
            $table->integer('unit_bp');
            $table->integer('total_bp');
            $table->string('supplier');
            $table->string('remarks')->nullable();
            $table->timestamps(); // created_at and updated_at

            // Optional: Add foreign key constraint
            $table->foreign('jobcard_id')->references('id')->on('jobcard')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobcard_detail');
    }
}
