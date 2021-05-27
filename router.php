<?php
	require_once('controller.php');
	
	$page = explode('/',$_SERVER['REQUEST_URI']);
	
	$method = $_SERVER['REQUEST_METHOD'];

    switch($page[2]) {
		case 'product' : 
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

		case 'client' : 
			switch($method) {
				case 'GET' : 
					$json = file_get_contents('login.html');
					echo displayLogin($json);
					break;
				case 'POST' :
					$json = file_get_contents('php://input');
					echo executeLogin($json);
					break;
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;	
		
		default : 
		http_response_code('500');
		echo 'unknown endpoint';
		break;
	
	}