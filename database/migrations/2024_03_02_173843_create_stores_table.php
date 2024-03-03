<?php

use App\Models\Store;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users')->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->string("slug")->nullable();
            $table->text("description")->nullable();
            $table->text("address")->nullable();
            $table->string("long")->nullable();
            $table->string("lat")->nullable();
            $table->string("thumbnail")->nullable();
            $table->json("operational_hour")->nullable();
            $table->tinyInteger("status")->default(Store::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
