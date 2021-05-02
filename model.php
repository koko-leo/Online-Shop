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
		$result = $cnx->query('select * from product');
		return $result->fetchall();
	}