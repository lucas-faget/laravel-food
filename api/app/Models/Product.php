<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'name',
        'calories',
        'carbohydrates',
        'lipids',
        'protein'
    ];

    protected $casts = [
        'calories' => 'float',
        'carbohydrates' => 'float',
        'fat' => 'float',
        'protein' => 'float'
    ];

    protected $primaryKey = 'id';

    protected $table = 'products';
}
