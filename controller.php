<?php
	require_once('model.php');
	
    session_start();
	
	function displayProducts() {
		return json_encode(getAllProducts());
	}
	
	function addToShoppingCart($value) {
		return json_encode(addToCart($value));
	}

	function removeFromShoppingCart($id_product) {
		return json_encode(removeProductFromCart($id_product));
	}