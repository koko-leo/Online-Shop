<?php
	require_once('model.php');
	
    session_start();

	function displayLogin(){
		return json_encode();
	}

	function executeLogin($form){
		$client = json_decode($form, true);
		return json_encode(doLogin($client['cltemail'], $planet['psw']));
	}
	
	function displayProducts() {
		return json_encode(getAllProducts());
	}
	
	function addToShoppingCart($form) {
		$product = json_decode($form, true);
		return json_encode(addToCart($product['id'], $product['quantity']));
	}

	function removeFromShoppingCart($id_product) {
		return json_encode(removeProductFromCart($id_product));
	}