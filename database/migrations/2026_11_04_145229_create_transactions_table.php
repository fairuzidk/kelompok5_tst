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
            $table->id();
            $table->string('judul', 100);
            $table->unsignedBigInteger('jumlah');
            $table->text('catatan')->nullable();
            $table->foreignId('category_id')->nullable()
              ->constrained('categories')->nullOnDelete();
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

Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->string('judul', 100);
    $table->unsignedBigInteger('jumlah');
    $table->text('catatan')->nullable();
    $table->foreignId('category_id')->nullable()
          ->constrained('categories')->nullOnDelete();
    $table->timestamps();
});