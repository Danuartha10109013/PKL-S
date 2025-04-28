<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductM extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'name',
        'status',
        'harga'
    ];
}
