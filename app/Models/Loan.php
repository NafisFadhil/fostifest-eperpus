<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'tb_loan';

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function code_book() {
        return $this->hasOne(BookCode::class, 'id', 'book_code_id');
    }

    public function review() {
        return $this->hasOne(Review::class, 'loan_id', 'id');
    }
}
