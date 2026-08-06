<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
//     public function up(): void
//     {
//         Schema::create('payments', function (Blueprint $table): void {
//             $table->id();
//             $table->decimal('amount', 8, 4);
//             $table->foreignId('order_id');
//             $table->foreignId('user_id');
//             $table->timestamps();
// 
//             $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
//             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//         });
//     }
public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('branch_id')->constrained();
        $table->foreignId('order_id')->constrained();
        $table->foreignId('user_id')->constrained();

        $table->decimal('amount',8,4);

        $table->timestamps();
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
