<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "ms_category";
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];
    public function books()
    {
        return $this->belongsToMany(Book::class, 'tb_book_category', 'category_id', 'book_id');
    }
    public function code()
    {
        return $this->hasOne(BookCode::class, 'book_id', 'id');
    }
}
