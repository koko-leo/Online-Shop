Document.prototype.ready = callback => {
	if(callback && typeof callback === 'function') {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return callback();
			}
		});
	}
};

document.ready( () => {
	
	fetch("./router.php/product")
		.then( response => response.json() )
		.then( data => {
			displayProducts(data);
		})
		.catch(error => { console.log(error) });
});

function showForm() {
	// this will make possible to see the products (shows the form of the products)
	document.getElementById('formProduct').style.display = 'initial';	
}

function hiddeShoppingCart() {
	// this will hidde the shopping cart, only displaying the products
	document.getElementById('divCart').style.display = 'none';	
}

function displayProducts(products) {

    const list = document.getElementById('list');

    var content = "";
    
    products.forEach(function(products) {

        content += "<div class='product'><p>" + products.name + "</p><br><p>$" + products.price 
					+ "</p><br><p><input type='number' name='quantity' id= 'inputquantity" + products.id + "' />"
					+ "</p><br><p><button onclick='addToCart(\"" + products.id + "\")'>Add To Shopping Cart</button></p><br></div>";     
	});
    
    content += "</div>";
    list.innerHTML = content;
}

function addToCart(id) {

	const form = {};
	form.id = id;
	form.quantity = document.getElementById('inputquantity'+ id).value;
	
	if(form.quantity < 1 ){
		alert("Insert positive quantity, please. Thank you :)")
	} else {
		fetch('./router.php/shopping_cart/', { method: 'POST', body: JSON.stringify(form)})
		.then(response => response.json())
		.then (data =>{
				displayShoppingCart(data);
		})
		.catch(error => { console.log(error) });
	}	
}

function displayShoppingCart(carts){
    
    const list = document.getElementById('divCart');

    var content = "<table><tr><td>Item Name</td><td>Quantity</td><td>Price</td><td>Total</td><td>Action</td><td><button onclick='showForm()'></td></tr>";
	
    // this loop will show every product added to the shopping cart in a table with a remove button for each
    carts.forEach(function (cart) {
		console.log(cart);
        content += '<tr><td>' + cart.name + "</td><td>"  
					+ cart.quantity  + "</td><td>"  
					+ cart.price + "</td><td>"  
					+ cart.quantity*cart.price 
					+ "</td><td><button onclick='removeItem(\"" + cart.id_product +  "\")'>Remove</button></td></tr>"; //remove with id and name (?)
    });
    content += "</table>";
    list.innerHTML = content;
}

function removeItem(id_product){

	fetch("./router.php/shopping_cart/" + id_product, { method: 'DELETE'})
	.then(response => response.json())
	.then (data =>{
			displayShoppingCart(data);
	})
	.catch(error => { console.log(error) });

}

document.getElementById('loginbtn').onclick = event => {
	event.preventDefault();
	window.location.replace('./login.html');
}


