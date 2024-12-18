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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->decimal('subtotal')->default(0);
            $table->decimal('shipping_price')->default(0);
            $table->decimal('bonuses')->default(0);
            $table->decimal('total')->default(0);
            $table->dateTime('time')->nullable();
            $table->text('notes')->nullable();
            $table->string('status');
            $table->boolean('paid')->default(false);
            $table->string('payment_method')->nullable();

            $table->unsignedBigInteger('details_id');
            $table->string('details_type');
            
            $table->foreignId('client_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
