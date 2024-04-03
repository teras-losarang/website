<?php

use App\Models\Modul;
use App\Models\Product;
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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->morphs('taggable');
            $table->string('name');
            $table->timestamps();
        });

        Schema::dropIfExists('product_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');

        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Product::class)->references('id')->on('products')->cascadeOnDelete();
            $table->foreignIdFor(Modul::class)->references('id')->on('moduls')->cascadeOnDelete();
        });
    }
};
