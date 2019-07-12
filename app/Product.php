<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Product extends Model
{
    use UsesUuid;

    protected $guarded = ['uuid'];

    protected $fillable = [
        'category_uuid', 'name', 'description', 'price', 'time_limit', 'time_start', 'user_uuid'
    ];
}
