<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
