<?php

	function connection() {
	
		$host = 'localhost';
		$user = 'mamp';
		$passwd = '1234';
		$dbname = 'online_store';

		$dsn = 'mysql:host='. $host .';dbname='. $dbname;
		$cnx = new PDO($dsn, $user, $passwd);
		if(!$cnx) {
			die('Connection failed');
		}
		return $cnx;
	}

	function doLogin($email, $passwd){
		$cnx = connection();
		$rqt = $cnx->prepare('SELECT * FROM client WHERE email= ? AND password = ?');
		$rqt->execute(array($email, $passwd));

		if ($rqt->rowCount() == 0) {
			http_response_code('500');
        }
		session_start();

	}

    function getAllProducts() {
		$cnx = connection();
		$result = $cnx->query('SELECT * FROM product ORDER BY id ASC');
		
		return $result->fetchall();
	}

	function getShoppingCart(){
		$cnx = connection();
		$result = $cnx->query('SELECT shopping_cart.*,product.name FROM shopping_cart JOIN product ON shopping_cart.id_product = product.id');
		
		return $result->fetchall(PDO::FETCH_ASSOC);
	}

	function addToCart($id, $quantity) {
		$cnx = connection();
		
		if(productExistInCart($id)) {
			$newquant = $cnx->query('SELECT quantity FROM shopping_cart WHERE id_product = '. $id) -> fetchColumn(0);
			$quantity += intval($newquant[0]);
			$rqt = $cnx->prepare('UPDATE shopping_cart SET quantity=? WHERE id_product = ?');
			$rqt->execute(array($quantity, $id));
		} else{
			$price = $cnx->query('SELECT price FROM product WHERE id = '. $id) -> fetchColumn(0);
			$rqt = $cnx->prepare('INSERT INTO shopping_cart(id_product, id_order, quantity, price) values( ?, ?, ?, ? )');
			$rqt->execute(array($id, 1 , $quantity , $price));
		}
		return getShoppingCart();
	}

	function productExistInCart($id){
		$cnx = connection();
		$count = $cnx->prepare('SELECT * FROM shopping_cart WHERE id_product = ?');
		$count->execute(array($id));

		if ($count->rowCount() == 0) {
			return false;
        }
		return true;
	}

	function getProductName($id_product) {
		$cnx = connection();
		$result = $cnx->query('SELECT name FROM product WHERE id ='. $id_product);
		return $result;
	}	

	function removeProductFromCart($id_product) {
		$cnx = connection();
		$rqt = $cnx->prepare('DELETE FROM shopping_cart WHERE id_product = ?');
		$rqt->execute(array($id_product));
		return getShoppingCart();
	}	

	function removeProductFromShop($id_product) {
		$cnx = connection();
		$rqt = $cnx->prepare('DELETE FROM product WHERE id = ?');
		$rqt->execute(array($id_product));
		return getAllProducts();
	}	

	function addNewProduct($name, $price, $category){
		$cnx = connection();
		$rqt = $cnx->prepare('INSERT INTO product(name, price, category) values( ?, ?, ? )');
		$rqt->execute(array($name, $price , $category));
		return getAllProducts();
		
	}

	function editAProduct($id, $name, $price, $category){
		$cnx = connection();

		$info = array($name, $price, $category);

		switch($info){
			case empty($info[0]): 
				
				switch($info){
					case empty($info[1]):
						$rqt = $cnx->prepare('UPDATE product SET category=? WHERE id ='. $id);
						$rqt->execute(array($category));
						break;
					case empty($info[2]):
						$rqt = $cnx->prepare('UPDATE product SET price=? WHERE id ='. $id);
						$rqt->execute(array($price));
						break;
					default:
						$rqt = $cnx->prepare('UPDATE product SET price=?, category=? WHERE id ='. $id);
						$rqt->execute(array($price , $category));
						break;
				}
			break;

			case empty($info[1]): 
				
				switch($info){
					case !empty($info[2]):
						$rqt = $cnx->prepare('UPDATE product SET name=?, price=? WHERE id ='. $id);
						$rqt->execute(array($name, $price));
						break;
					default:
						$rqt = $cnx->prepare('UPDATE product SET name=? WHERE id ='. $id);
						$rqt->execute(array($name));
						break;
				}
			break;

			case empty($info[2]): 
				
				switch($info){
					case !empty($info[1]):
						$rqt = $cnx->prepare('UPDATE product SET name=?, price=? WHERE id ='. $id);
						$rqt->execute(array($name, $price));
						break;
					default:
						break;
				}
			break;

			default:
				$rqt = $cnx->prepare('UPDATE product SET name=?, price=?, category=? WHERE id ='. $id);
				$rqt->execute(array($name, $price , $category));
			break;
		}

		return getAllProducts();
	}
