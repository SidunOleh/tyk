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
        Schema::create('dispatcher_work_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->unsignedBigInteger('dispatcher_id')->nullable();
            $table->foreign('dispatcher_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('work_shift_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('food_shipping_count')->default(0);
            $table->integer('shipping_count')->default(0);
            $table->integer('taxi_count')->default(0);
            $table->decimal('food_shipping_total')->default(0);
            $table->decimal('shipping_total')->default(0);
            $table->decimal('taxi_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatcher_work_shifts');
    }
};
