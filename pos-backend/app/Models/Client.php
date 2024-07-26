<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'pos_client';
    protected $primaryKey = 'client_id';

    protected $fillable = [
        //'client_id',
        'doc_type',
        'doc_number',
        'first_name',
        'last_name',
        'phone',
        'email'
    ];

}
