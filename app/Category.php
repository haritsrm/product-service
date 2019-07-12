<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Category extends Model
{
    use UsesUuid;

    protected $guarded = ['uuid'];

    // protected $fillable = [
    //     'name', 'description'
    // ];
}
