<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

		protected $table = 'ms_kelas';
		protected $primaryKey = 'id';
		protected $keyType = 'string';
		public $incrementing = false;
		protected $guarded = [];

		public function users() {
			return $this->hasMany(User::class);
		}
}
