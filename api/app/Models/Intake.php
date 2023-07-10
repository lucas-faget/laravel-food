<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;

    protected $table = 'intakes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'product_id',
        'grams',
        'date',
        'time'
    ];

    protected $casts = [
        'grams' => 'float',
    ];

    protected $dates = [
        'date',
        'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
