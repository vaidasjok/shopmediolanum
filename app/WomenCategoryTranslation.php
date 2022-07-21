<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WomenCategoryTranslation extends Model
{
    protected $table = 'women_category_translations';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
}
