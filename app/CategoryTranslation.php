<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class CategoryTranslation extends Model
{
    protected $fillable = ['name', 'description'];
	protected $table = 'category_translations';
	public $timestamps = false;
}
