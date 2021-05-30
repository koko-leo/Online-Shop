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

function empty(value){
    return (value == null || value.length === 0);
}

document.getElementById('submit').onclick = event => {
	
	event.preventDefault();

	const form = {};
	form.email = document.getElementById('client-email').value;
	form.psw = document.getElementById('client-psw').value;

	if(empty(form.email) || empty(form.psw)){
		alert("Please fill with your Email and Password.");
	} else {
		console.log(form.email);
		console.log(form.psw);
		fetch('/router.php/client/', { method: 'POST', body: JSON.stringify(form)})
		.then(function(response){
			if(response.ok){
				window.location.replace('../')
			} else {
				alert("Do you have an account? If yes, please check again your Email or Password! :D");
			}
			
		});
	}
}