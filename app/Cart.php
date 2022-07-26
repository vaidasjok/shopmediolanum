<?php

namespace App;

class Cart 
{
	public $items; // ['id' => ['quantity' => , 'price' => , 'data' => ], ... ]
	public $totalQuantity;
	public $totalPrice;

	/**
	 *
	 * Cart Constructor
	 *
	 */
	public function __construct($prevCart) 
	{
		if($prevCart != null) {
			$this->items = $prevCart->items;
			$this->totalQuantity = $prevCart->totalQuantity;
			$this->totalPrice = $prevCart->totalPrice;
		} else {
			$this->items = [];
			$this->totalQuantity = 0;
			$this->totalPrice = 0;
		}
	}

	public function addItem($attribute_id, $product, $price = null, $size = null) 
	{
		// $price = (int) str_replace('€', '', $product->price);
		// the item already exists
		if(array_key_exists($attribute_id, $this->items)) {
			$productToAdd = $this->items[$attribute_id];
			$productToAdd['quantity']++;
			$productToAdd['totalSinglePrice'] = $productToAdd['quantity'] * $price;

		// first time to add this productto cart
		} else {
			$productToAdd = ['quantity' => 1, 'totalSinglePrice' => $price, 'data' => $product, 'size' => $size, 'price' => $price, 'attribute_id' => $attribute_id];
		}

		$this->items[$attribute_id] = $productToAdd;
		$this->totalQuantity++;
		$this->totalPrice = $this->totalPrice + $price;
	}

	public function removeItem($attribute_id) 
	{
		//paimu viena konkretu produkta is atminties
		$singlePproductToRemove = $this->items[$attribute_id];

		//mazinu vieno paimto konkretaus produkto kieki ir suma
		if($singlePproductToRemove['quantity'] > 1) {
			$singlePproductToRemove['quantity']--;
		
			$singlePproductToRemove['totalSinglePrice'] = $singlePproductToRemove['quantity'] * $singlePproductToRemove['price'];
			//grazina koreguotus produkto duomenis atgal i atminti
			$this->items[$attribute_id] = $singlePproductToRemove;


			//bendru kiekiu mazinimas
			// $this->totalQuantity = $this->totalQuantity - 1;
			// $this->totalPrice = $this->totalPrice - $singlePproductToRemove['data']['price'];

			//bendru kiekiu mazinimas - tik panaudojant jau turima funkcialuma
			$this->updatePriceAndQuantity();
		}

	}

	public function updatePriceAndQuantity() 
	{
		$totalPrice = 0;
		$totalQuantity = 0;

		foreach($this->items as $item) {
			$totalQuantity = $totalQuantity + $item['quantity'];
			$totalPrice = $totalPrice + $item['totalSinglePrice'];
		}

		$this->totalQuantity = $totalQuantity;
		$this->totalPrice = $totalPrice;
	}


}