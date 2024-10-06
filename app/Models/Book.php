<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = "ms_book";
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tb_book_category', 'book_id', 'category_id');
    }
    public function codes()
    {
        return $this->hasMany(BookCode::class, 'book_id', 'id');
    }
}
