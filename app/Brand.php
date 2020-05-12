<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['description'];

    protected $table = 'brands';

    protected $fillable = ['product_id', 'name'];

    public function products() 
    {
    	return $this->hasMany('App\Product', 'product_id');
    }
}
