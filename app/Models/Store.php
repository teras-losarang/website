<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Store extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const IN_ACTIVE = 0;

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
        "operational_hour"
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
