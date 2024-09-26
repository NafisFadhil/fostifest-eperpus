<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

		protected $table = 'ms_role';
		protected $primaryKey = 'id';
		protected $keyType = 'string';
		public $incrementing = false;
		protected $guarded = [];
}
