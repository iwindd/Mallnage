<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrows extends Model
{
    use HasFactory;

    protected $fillable = [
        'cooperative',
        'product',
        'quantity',
        'used',
        'note',
        'note2',
        'status',
        'closeType',
        'created_at',
        'updated_at'
    ];
}
