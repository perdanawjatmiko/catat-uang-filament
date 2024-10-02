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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->foreignUuid('account_id');
            $table->integer('amount')->default(0);
            $table->string('type');
            $table->foreignId('category_id')->nullable();
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->foreignUuid('budget_id')->nullable();
            $table->dateTime('transaction_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
