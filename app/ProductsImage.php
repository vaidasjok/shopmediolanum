<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
    protected $table = "products_images";

    protected $fillable = [
        'image', 'product_id',
    ];
}
