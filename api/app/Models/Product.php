<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'barcode',
        'name',
        'brand',
        'image_url',
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
}
