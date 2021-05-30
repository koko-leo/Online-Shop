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
					echo newProduct($json);
					break;
				case 'DELETE' : 
					echo removeProduct($page[3]);
					break;
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;

		case 'client' : 
			switch($method) {
		
				case 'POST' :
					$json = file_get_contents('php://input');
					echo executeLogin($json);
					break;
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;	
		
		case 'shopping_cart' : 
			switch($method) {
				case 'POST' :
					$json = file_get_contents('php://input');
					echo addToShoppingCart($json);
					break;
				case 'DELETE' : 
					echo removeFromShoppingCart($page[3]);
					break;
	
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;

		case 'edit' : 
			switch($method) {
				case 'POST' :
					$json = file_get_contents('php://input');
					echo editProduct($json);
					break;
				default:
					http_response_code('404');
					echo 'OOPS';
			}
			break;

		case 'signup' : 
			switch($method) {
				case 'POST' :
					$json = file_get_contents('php://input');
					echo clientSignUp($json);
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