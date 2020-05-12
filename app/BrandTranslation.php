<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    
	protected $table = 'brand_translations';
    protected $fillable = ['description'];
    public $timestamps = false;
}
