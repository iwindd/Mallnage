<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
        'cooperative',
        'trade_item',
        'trade_quantity',
        'trade_price',
        'created_at'
    ];
}
