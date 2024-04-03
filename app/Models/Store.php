<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Store extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const IN_ACTIVE = 0;

    const DEFAULT_IMAGE = "assets/img/ecommerce-images/default.jpg";

    protected $fillable = [
        "user_id",
        "name",
        "slug",
        "description",
        "address",
        "long",
        "lat",
        "thumbnail",
        "status",
        "operational_hour",
        "tags"
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "store_id", "id");
    }

    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
