<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',        // Add product name
        'description', // Add product description
        'price',       // Add product price
        'quantity',    // Add product quantity
    ];
}
