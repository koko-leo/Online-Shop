<?php
	require_once('model.php');
	
    session_start();

	function displayLogin(){
		return json_encode();
	}

	function executeLogin($form){
		$client = json_decode($form, true);
		return json_encode(doLogin($client['email'], $planet['psw']));
	}
	
	function displayProducts() {
		return json_encode(getAllProducts());
	}
	
	function addToShoppingCart($form) {
		$product = json_decode($form, true);
		return json_encode(addToCart(intval($product['id'],10), intval($product['quantity'],10)));
	}

	function removeFromShoppingCart($id_product) {
		return json_encode(removeProductFromCart($id_product));
	}

	function removeProduct($id_product) {
		return json_encode(removeProductFromShop($id_product));
	}

	function newProduct($form){
		$product = json_decode($form, true);
		return json_encode(addNewProduct($product['name'], intval($product['price'],10), $product['category']));
	}

	function editProduct($form){
		$product = json_decode($form, true);
		return json_encode(editAProduct($product['id'], $product['name'], intval($product['price'],10), $product['category']));
	}