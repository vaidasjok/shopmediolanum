<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
    	'image', 'price', 'type', 'category_id', 'size_and_fit', 'enabled', 'brand_id'
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

    public function brand() 
    {
        return $this->belongsTo('App\Category');
    }
}
