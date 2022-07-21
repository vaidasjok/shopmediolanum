<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    protected $fillable = [
    	'date', 'status', 'del_date', 'price', 'first_name', 'address', 'last_name', 'phone', 'zip', 'email', 'country'
    ];

    public function orderItems() 
    {
    	return $this->hasMany('App\OrderItem', 'order_id');
    }
}
