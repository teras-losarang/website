<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const IN_ACTIVE = 0;

    protected $fillable = [
        "store_id",
        "name",
        "slug",
        "description",
        "stock",
        "price",
        "status",
        "enable_variant",
    ];

    public function store(): HasOne
    {
        return $this->hasOne(Store::class, "id", "store_id");
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
}
