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
        'api_id',
        'name',
        'image',
        'brand',
        'category',
        'tags',
        'calories',
        'fat',
        'carbohydrates',
        'protein',
        'ingredients'
    ];

    protected $casts = [
        'calories' => 'float',
        'protein' => 'float',
        'fat' => 'float',
        'carbohydrates' => 'float'
    ];
}
