$(document).on('click', '#login', function(){
	$.ajax({
		type: 'POST',
		url: 'users.php',
		data: {username: $('#username').val(), password: $('#password').val()},
		dataType: 'json',
		success: function(data){
			alert("ran through");
			window.location.replace("http://localhost/teemplayweb/idea_viewing.php");
		},
		error: function(data, error){
			console.debug(data);
			console.debug(error);
		}

	});
	/*($.post("users.php", {username: $('#username').val(), password: $('#password').val(), 
		$('#email').val(), level: '1', description: "", votes: '0', salt: 'qwerty'}, function(data){
			alert("yoyo");
		}, "json");*/
});