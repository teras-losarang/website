<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modul extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const NON_ACTIVE = 0;

    const SORT_UP = 'up';
    const SORT_DOWN = 'down';

    const SEE_MORE = 1;

    protected $guarded = [''];
}
