<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Mass assignment fields
    protected $fillable = ['title', 'author', 'stock'];

    public function borrowings()
{
    return $this->belongsToMany(Borrowing::class, 'borrowing_book', 'book_id', 'borrowing_id');
}

}
