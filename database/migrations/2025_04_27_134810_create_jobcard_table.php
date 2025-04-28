<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobcardTable extends Migration
{
    public function up(): void
    {
        Schema::create('jobcard', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('no_jobcard');
            $table->date('date');
            $table->integer('kurs');
            $table->string('customer_name');
            $table->string('no_po');
            $table->date('po_date');
            $table->date('po_received');
            $table->integer('totalbop')->nullable();
            $table->integer('totalsp')->nullable();
            $table->integer('totalbp')->nullable();
            $table->string('no_form');
            $table->date('effective_date');
            $table->integer('no_revisi')->default(1);
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobcard');
    }
}
