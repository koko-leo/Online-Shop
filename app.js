Document.prototype.ready = callback => {
	if(callback && typeof callback === 'function') {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return callback();
			}
		});
	}
};

function showForm() {
	// this will make possible to see the products (shows the form of the products)
	document.getElementById('formProduct').style.display = 'initial';	
}

function hiddeShoppingCart() {
	// this will hidde the shopping cart, only displaying the products
	document.getElementById('divCart').style.display = 'none';	
}



function displayProducts(products) {
    
    hiddeShoppingCart();

    const list = document.getElementById('list');

    var content = "<tr><td>Name</td><td>Caracteristics</td><td><button onclick='showForm()'>Add To Shopping Cart</button></td></tr>";
    
    products.forEach(function(products) {

        content += "<h2 class=text-info>" + products.name + "</h2><h2 class=text-danger>$" + products.price;     
        
    });
    
    content += "</h2>";
          
    list.innerHTML = content;
}

function displayShoppingCart(cart){
    
    const list = document.getElementById('divCart');

    var content = "<table><tr><td>Item Name</td><td>Quantity</td><td>Price</td><td>Total</td><td>Action</td><td><button onclick='showForm()'></td></tr>";
  
    // this loop will show every product added to the shopping cart in a table with a remove button for each
    cart.forEach(function (cart) {
        content += '<tr><td>' + getProductName(cart.id_product) + "</td><td>"  + cart.quantity  + "</td><td>"  + cart.price + "</td><td>"  + cart.quantity*cart.price + "</td><td><button onclick='remove(\"" + getProductName(cart.id_product) +  "\")'>Remove</button></td></tr>";
    });
    content += "</table>";
    list.innerHTML = content;
}

document.getElementById('adding').onclick = event => {
	// This function is attached to the button 'adding' once the page is loaded
	//When the user valids his form, we avoid the reload of the page
	event.preventDefault();
	//we hide the form (to go back to the visual state at the beginning
	hiddeShoppingCart();

	// Building the request, in JSON, and send it to the server
    const form = {};
	form.nom = document.getElementById('input-quantity').value;
	
	fetch('./router.php/shopping_cart', { method: 'POST', body: JSON.stringify(form)})
	.then(response => response.json())
	.then (data =>{
			//once again, we need to display the data. The function 'displayPlanets' is for that purpose
			displayShoppingCart(data);
	})
	.catch(error => { console.log(error) });	
}

