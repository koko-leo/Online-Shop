Document.prototype.ready = callback => {
	if(callback && typeof callback === 'function') {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return callback();
			}
		});
	}
};



function displayProducts(products) {
    
    const list = document.getElementById('list');

    var content = "<div style=border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px; align=center>";
    
    products.forEach(function(products) {

        content += "<h4 class=text-info>" + products.name + "</h4><h4 class=text-danger>$" + products.price;     
        
    });
    
    content += "</h4><input type=text name=quantity class=form-control value=1 /><input type=submit name=add_to_cart style=margin-top:5px; class=btn btn-success value='Add to Cart' /></div>";
          
    list.innerHTML = content;
}

function displayShoppingCart(){

}

