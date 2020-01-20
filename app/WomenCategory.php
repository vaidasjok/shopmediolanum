<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WomenCategory extends Model
{
    protected $table = "women_categories";

    public function categories()
    {
    	return $this->hasMany('App\WomenCategory', 'parent_id');
    }

}
