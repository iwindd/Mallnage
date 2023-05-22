<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'cooperative',
        'categoryId',
        'serial',
        'barcodeGen',
        'name',
        'price',
        'cost',
        'quantity',
        'sold',
        'added',
        'image',
        'isRetail'
    ];
}
