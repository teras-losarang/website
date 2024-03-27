<?php

use App\Models\Address;
use App\Models\Cart;
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
            $table->foreignIdFor(Cart::class)->references('id')->on('carts')->cascadeOnDelete();
            $table->foreignIdFor(Address::class)->references('id')->on('addresses')->cascadeOnDelete();
            $table->tinyInteger('status');
            $table->integer('shipping_cost');
            $table->integer('service_fee');
            $table->integer('total_cost');
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
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
