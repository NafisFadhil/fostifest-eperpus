<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $table = 'ms_level';
    protected $casts = [
        'id' => 'string',
    ];
    protected $guarded = [];
}
