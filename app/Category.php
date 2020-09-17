<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = ['product_id', 'url', 'status'];

    public function categories()
    {
    	return $this->hasMany('App\Category', 'parent_id');
    }
}
