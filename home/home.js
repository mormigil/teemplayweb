/*home.js*/

$(document).keyup(function (e) {
    if (("#email:focus")&&(e.keyCode == 13)) {
        submit();
    }
});

$(document).on("click", "#signup", function(){
	submit();
});

function submit(){
	var email = $("#email").val();
	if(validateEmail(email)){
		$.ajax({
			type: "POST",
			url: "emaillist.php",
			data: {email: email},
			dataType: 'json',
			success: function(data){
				alert("Thank you for signing up. We'll be in contact soon!");
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert(errorThrown);
				alert("Error submitting your email. You've probably already signed up.");
			}
		});
	}
	else{
		alert("Invalid email address. Please submit a full email address typically of format s@dom.ain");
	}
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}