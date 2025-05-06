<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notif', function (Blueprint $table) {
            $table->unsignedBigInteger('po_id')->nullable()->after('user_id'); // tambahkan setelah 'user_id' jika ada
        });
    }

    public function down()
    {
        Schema::table('notif', function (Blueprint $table) {
            $table->dropColumn('po_id');
        });
    }
};
