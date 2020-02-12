<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontendImage extends Model
{
    protected $table = 'frontend_images';

    protected $fillable = ['type', 'title', 'image', 'link', 'enabled'];
}
