<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'uniform_category_id',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'stocks',
        'has_variant',
    ];
}
