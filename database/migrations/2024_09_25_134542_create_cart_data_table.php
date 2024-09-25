<?php

use App\Models\Products;
use App\Models\User;
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
        Schema::create('cart_data', function (Blueprint $table) {
            $table->id(); 
            $table->enum('status', ['active', 'completed', 'abandoned'])->default('active');
            $table->string('session_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('products_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity'); 
            $table->decimal('price', 8, 2); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_data');
    }
};
