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
        Schema::create('zaklad_addon_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zaklad_id')->nullable();
            $table->foreign('zaklad_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->foreignId('order_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('amount');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zaklad_addon_amounts');
    }
};
