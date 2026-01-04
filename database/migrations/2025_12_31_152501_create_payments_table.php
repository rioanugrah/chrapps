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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('amount', 20, 2);
            $table->decimal('fee_admin', 20, 2);
            $table->string('payment_method', 50)->nullable();
            $table->text('payment_references')->nullable();
            $table->text('payment_billing')->nullable();
            $table->text('payment_order')->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Canceled', 'Expired'])->default('Pending');
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
