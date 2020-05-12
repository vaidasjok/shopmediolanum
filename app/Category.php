<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = ['product_id', 'url', 'status'];

    public function categories()
    {
    	return $this->hasMany('App\Category', 'parent_id');
    }
}
