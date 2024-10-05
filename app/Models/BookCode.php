<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCode extends Model
{
    use HasFactory;
    protected $table = "ms_book_code";
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];

    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
    public function loan()
    {
        return $this->hasMany(Loan::class, 'book_code_id', 'id');
    }
}
