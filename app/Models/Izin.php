<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

		protected $table = 'tb_izin';
		protected $primaryKey = 'id';
		protected $keyType = 'string';
		public $incrementing = false;
		protected $guarded = [];

		public function user() {
			return $this->belongsTo(User::class);
		}
}
