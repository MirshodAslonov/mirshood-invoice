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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->jsonb('items');            // [{name, qty?, price}]
            $table->string('currency', 8)->default('USD');

            $table->unsignedBigInteger('subtotal')->default(0); // so'm/tiyin/cent ko'rinishida int (eng xavfsiz)
            $table->unsignedBigInteger('tax')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total')->default(0);

            $table->enum('status', ['pending','paid','overdue'])->default('pending');
            $table->date('due_date')->nullable();

            $table->string('pdf_path')->nullable(); // storage path
            $table->timestamps();

            $table->index(['user_id','client_id']);
            $table->index(['status','due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
