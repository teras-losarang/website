<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tag extends Model
{
    use HasFactory;

    const STORE = "App\Models\Store";
    const PRODUCT = "App\Models\Product";

    protected $guarded = [''];

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}
