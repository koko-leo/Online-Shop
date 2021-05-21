<?php
	require_once('model.php');
	
    session_start();
	
	function displayProducts() {
		return json_encode(getAllProducts());
	}
	
	function addToShoppingCart($value) {
		return json_encode(addToCart($value));
	}

	/***************************/
	function addAPlanet($form) {
		//we want the data as an associative array
		$planet = json_decode($form, true);
		return json_encode(addPlanet($planet['nom'], $planet['carac']));
	}
	function deleteAPlanet($name) {
		return json_encode(deletePlanet($name));
	}