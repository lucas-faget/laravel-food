<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'api_id',
        'name',
        'image',
        'country',
        'brand',
        'description',
        'category',
        'tags',
        'ingredients',
        'serving_size_unit',
        'serving_size',
        'calories',
        'fat',
        'carbohydrates',
        'protein',
    ];

    protected $casts = [
        'serving_size' => 'float',
        'calories' => 'float',
        'fat' => 'float',
        'carbohydrates' => 'float',
        'protein' => 'float',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_product');
    }
}
