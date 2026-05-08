<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddProduct extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'delivery_fee',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_product',
            'product_id',
            'category_id'
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
