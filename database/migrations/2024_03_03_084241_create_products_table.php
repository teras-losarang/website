<?php

use App\Models\Product;
use App\Models\Store;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Store::class)->references("id")->on("stores")->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->string("slug")->nullable();
            $table->text("description")->nullable();
            $table->string("stock")->nullable();
            $table->string("price")->nullable();
            $table->tinyInteger("status")->default(Product::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
