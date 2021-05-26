<?php
	
	$host = 'localhost';
	$user = 'mamp';
	$passwd = 'imac';
	$dbname = 'online_store';

	$dsn = 'mysql:host='. $host .';dbname='. $dbname;

	function connection() {
		$cnx = new PDO($dsn, $user, $passwd);
		if(!$cnx) {
			die('Connection failed');
		}
		return $cnx;
	}

    function getAllProducts() {
		$cnx = connection();
		$result = $cnx->query('SELECT * FROM product ORDER BY id ASC');
		
		return $result->fetchall();
	}

	function getShoppingCart(){
		$cnx = connection();
		$result = $cnx->query('SELECT * FROM shopping_cart');
		
		return $result->fetchall();
	}

	function addToCart($id, $quantity, $price) {
		$cnx = connection();
		$rqt = $cnx->prepare('INSERT INTO shopping_cart(id_product, id_order, quantity, price) values( ?, 1, ?, ? )');
		$rqt->execute(array($id, 1 ,$quantity, $price));
		return getShoppingCart();
	}

	function getProductName($id_product) {
		$cnx = connection();
		$result = $cnx->query('SELECT name FROM product WHERE id = id_product');
		return $result;
	}	

	function removeProductFromCart($id_product) {
		$cnx = connection();
		$rqt = $cnx->prepare('DELETE FROM shopping_cart WHERE id_product = ?');
		$rqt->execute(array($id_product));
		return getAll();
	}	