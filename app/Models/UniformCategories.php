<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'uniform_name',
    ];
}
