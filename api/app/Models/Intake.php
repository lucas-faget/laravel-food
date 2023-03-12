<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'time'
    ];

    protected $dates = [
        'date',
        'time'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $primaryKey = 'id';

    protected $table = 'intakes';
}
