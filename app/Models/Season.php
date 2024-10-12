<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

		protected $table = 'ms_season';
		protected $primaryKey = 'id';
		protected $keyType = 'string';
		public $incrementing = false;
		protected $guarded = [];
}
