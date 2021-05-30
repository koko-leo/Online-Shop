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
	showLoginForm();
});

function showLoginForm(){
	document.getElementById('formLogin').style.display = 'initial';
}

document.getElementById('submit').onclick = event => {
	
	event.preventDefault();

	const form = {};
	form.email = document.getElementById('client-email').value;
	form.psw = document.getElementById('client-psw').value;
	
	fetch('/router.php/client', { method: 'POST', body: JSON.stringify(form)})
    .then(function(response){
        if(response.ok){
            window.location.replace('../')
        } else {
            alert("Go away!");
        }
        
    });

}