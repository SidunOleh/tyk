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
        Schema::create('zaklad_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('work_shift_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('total')->default(0);
            $table->decimal('returned_amount')->default(0);
            $table->string('payment_method')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zaklad_reports');
    }
};
