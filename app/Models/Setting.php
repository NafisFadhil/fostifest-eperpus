<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

		protected $table = 'ms_setting';
		protected $primaryKey = 'id';
		protected $keyType = 'string';
		public $incrementing = false;
		protected $guarded = [];

}
