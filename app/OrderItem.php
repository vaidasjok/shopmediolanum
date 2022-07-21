<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
    	'item_id', 'order_id', 'item_name', 'item_price', 'quantity', 'size'
    ];

    public function order() 
    {
    	return $this->belongsTo('App\Order');
    }
}
