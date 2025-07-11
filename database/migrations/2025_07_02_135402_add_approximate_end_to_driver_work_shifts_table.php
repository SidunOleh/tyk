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
        Schema::table('driver_work_shifts', function (Blueprint $table) {
            $table->dateTime('approximate_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_work_shifts', function (Blueprint $table) {
            $table->dropColumn('approximate_end');
        });
    }
};
