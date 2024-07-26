<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'pos_book';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        //'book_id',
        'isbn',
        'name',
        'stock',
        'current_price',
        'image_book'
    ];
}
