/*home.js*/

$(document).on("click", "#signup", function(){
	var email = $("#email").val();
	if(validateEmail(email)){
		$.post("emailList.php", {email: email}, function(){
			alert("Thank you for signing up. We'll be in contact soon!");
		});
	}
});

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\
".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA
-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 