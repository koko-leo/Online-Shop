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
	showSignUpForm();
});

function showSignUpForm(){
	document.getElementById('formSignUp').style.display = 'initial';
}

function empty(value){
    return (value == null || value.length === 0);
}

document.getElementById('submit').onclick = event => {
	
	event.preventDefault();

	const form = {};
    form.username = document.getElementById('user_name').value;
	form.email = document.getElementById('email').value;
	form.psw = document.getElementById('password').value;
    var confirmpsw = document.getElementById('confirm_password').value;

	if(empty(form.username) || empty(form.email) || empty(form.psw) || empty(confirmpsw)){
		alert("Please fill everything!");
	} else {
		if(form.psw.length < 8 || confirmpsw.length < 8){
			alert("Password must have at least 8 characters.");
		} else {
			if(form.psw != confirmpsw){
				alert("Password did not match.");
			} else {
				if(!form.email.includes('@')){
					console.log(form.email.includes('@'));
					alert("Please insert a valid Email.")
				} else {
					fetch('/router.php/signup', { method: 'POST', body: JSON.stringify(form)})
					.then(function(response){
						if(response.ok){
							alert("Account created with success! Welcome to our shop :)")
							window.location.replace('../')
						} else {
							alert("I apologize! Something went wrong. Maybe you already have an account. ¯\_(ツ)_/¯");
						}
						
					});
				}
			}
		}
	}
	
	

}