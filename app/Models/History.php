<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        'cooperative',
        'created_by',
        'note',
        'product',
        'product_borrows',
        'price',
        'qrcode',
        'temp',

        'firstname',
        'lastname',
        'department',
        'address',
        'district',
        'area',
        'province',
        'postalcode',
        'isRetail'
    ];
}
