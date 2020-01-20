<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'name', 'description', 'image', 'price', 'type', 'category_id'
    ];

    public function getPriceAttribute($value) {
    	// $newForm = '€' . $value;
    	// return $newForm;
    	return $value;
    }

    public function attributes() 
    {
    	return $this->hasMany('App\ProductAttribute', 'product_id');
    }

    public function categories() 
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
}
