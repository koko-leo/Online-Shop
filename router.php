<?php
	require_once('controller.php');
	
	$page = explode('/',$_SERVER['REQUEST_URI']);
	
	$method = $_SERVER['REQUEST_METHOD'];

    switch($page[2]) {
		case 'products' : 
			switch($method) {
				case 'GET' : 
					echo displayProducts();
					break;
				case 'POST' :
					$json = file_get_contents('php://input');
					echo addToShoppingCart($json);
					break;
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;
	
	}