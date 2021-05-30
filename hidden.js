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
        
        document.getElementById('formNewProduct').hidden = true;
});

function displayProducts(products) {

    const list = document.getElementById('list');

    var content = "";
    
    products.forEach(function(products) {

        content += "<div class='product'><p>" + products.name + "</p><br><p>$" + products.price 
					+ "</p><br><p><button onclick='editProduct(\"" + products.id + "\")'>Edit Product</button></p>"
					+ "<p><button onclick='removeProduct(\"" + products.id + "\")'>Remove Product</button></p><br></div>";     
	});
    
    content += "</div>";
    list.innerHTML = content;
}

function editProduct(id_product){

    document.getElementById('formNewProduct').hidden = false;

    document.getElementById('submit').onclick = event => {
        
        const form = {};
        form.id = id_product;
        form.name = document.getElementById('input-name').value;
        form.price = document.getElementById('input-price').value;
        form.category = document.getElementById('input-category').value;

        if(form.price < 0 ){
            alert("Information incorrect! Try to use a positive price... This shop needs money!");
        } else {
            fetch('./router.php/edit', { method: 'POST', body: JSON.stringify(form)})
            .then(response => response.json())
            .then(document.getElementById('formNewProduct').hidden = true)
            .then (data =>{
                    displayProducts(data);
            })
            .catch(error => { console.log(error) });
    }
    }
    clearForm();
}

function removeProduct(id_product){

	fetch("./router.php/product/" + id_product, { method: 'DELETE'})
	.then(response => response.json())
	.then (data =>{
			displayProducts(data);
	})
	.catch(error => { console.log(error) });

}

function empty(value){
    return (value == null || value.length === 0);
  }

document.getElementById('add').onclick = event => {
	event.preventDefault();

    document.getElementById('formNewProduct').hidden = false;

    document.getElementById('submit').onclick = event => {
        
        const form = {};
        form.name = document.getElementById('input-name').value;
        form.price = document.getElementById('input-price').value;
        form.category = document.getElementById('input-category').value;

        if(form.price < 0 || empty(form.name) || empty(form.price) || empty(form.category) ){
            alert("Information incorrect! Try to use a positive price... This shop needs money!");
        } else {
            fetch('./router.php/product/', { method: 'POST', body: JSON.stringify(form)})
            .then(response => response.json())
            .then(data =>{ 
                 displayProducts(data)
            }) 
            .then(document.getElementById('formNewProduct').hidden = true)
            .catch(error => { console.log(error) });
        }
    }
    clearForm();
}

function clearForm(){
    // clear the values of the form
    document.getElementById('input-name').value = '';
    document.getElementById('input-price').value = '';
    document.getElementById('input-category').value = '';
}
