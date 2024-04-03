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
        Schema::table('stores', function (Blueprint $table) {
            $table->text("tags")->nullable()->after('thumbnail');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->text("tags")->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('tags');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
};
