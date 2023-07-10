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
        'serving_size',
        'energy',
        'protein',
        'total_fat',
        'saturated_fat',
        'carbohydrates',
        'sugars',
        'sodium'
    ];

    protected $casts = [
        'serving_size' => 'integer',
        'energy' => 'integer',
        'protein' => 'float',
        'total_fat' => 'float',
        'saturated_fat' => 'float',
        'carbohydrates' => 'float',
        'sugars' => 'float',
        'sodium' => 'float'
    ];
}
