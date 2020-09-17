<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
{
    use Translatable;

    public $translatedAttributes = ['description'];

    protected $table = 'brands';

    protected $fillable = ['product_id', 'name'];

    public function products() 
    {
    	return $this->hasMany('App\Product', 'product_id');
    }
}
