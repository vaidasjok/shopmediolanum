<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WomenCategory extends Model
{
    use \Dimsav\Translatable\Translatable;


    public $translatedAttributes = ['name', 'description'];

    protected $fillable = ['product_id', 'url', 'status'];

    public function women_categories()
    {
    	return $this->hasMany('App\WomenCategory', 'parent_id');
    }


}
