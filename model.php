<?php
	
	function connection() {
		$cnx = new PDO('mysql:host=localhost;dbname=online_store', 'imac','cami');
		if(!$cnx) {
			die('Connection failed');
		}
		return $cnx;
	}

    function getAllProducts() {
		$cnx = connection();
		$result = $cnx->query('select * from product ORDER BY id ASC');
		
		return $result->fetchall();
	}

	function getShoppingCart(){
		$cnx = connection();
		$result = $cnx->query('select * from shopping_cart');
		
		return $result->fetchall();
	}

	function addToCart($id, $value) {
		$cnx = connection();
		$rqt = $cnx->prepare('insert into shopping_cart(id_product, id_order, quantity) values( ?, 1, ? )');
		$rqt->execute(array($id, 1 ,$value));
		return getShoppingCart();
	}