<?php

namespace App;

class Wishlist 
{
	public $items; 
	public $totalQuantity;

	/**
	 *
	 * Wishlist Constructor
	 *
	 */
	public function __construct($prevList) 
	{
		
		if($prevList != null) {
			$this->items = $prevList->items;
			$this->totalQuantity = $prevList->totalQuantity;
		} else {
			$this->items = [];
			$this->totalQuantity = 0;
		}
	}

	public function addRemoveItem($product_id) 
	{
		// dd(array_key_exists($product_id, $this->items));
		// the item already exists
		if(array_key_exists($product_id, $this->items)) {
			unset($this->items[$product_id]);
			$this->totalQuantity--;

		// first time to add this product to llist
		} else {
			$this->items[$product_id] = $product_id;
			$this->totalQuantity++;
		}
		// dd($this->items);

	}

	public function getList() {
		return $this->items;
	}

	public function getListArray() {
		$array = [];
		foreach($this->items as $key => $value) {
			array_push($array, $value);
		}
		return $array;
	}


}