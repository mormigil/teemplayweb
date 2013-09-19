$(document).on('click', '#gameidea', function(){
	var user_id = getCookie('username');
	$.ajax({
		type: 'POST',
		url: 'ideas.php',
		data: {id: null, userid: user_id, title: $("#title").val(), tweet: $("#tweet").val(),
			description: $("#description").val(), genre: $("#genre").val()},
		dataType: 'json',
		success: function(data){
			alert("ran through");
		},
		error: function(data, error){
			console.debug(data);
			console.debug(error);
		}
	});
});
/* Would be used if you could change an idea after submitting it. 
$(document).on('click', '#changeidea', function(){
	var user = getCookie('username');
	var user_id;
	$.ajax({
		type: 'GET',
		url: 'users.php',
		data: {username: user},
		dataType: 'json',
		success: function(data){
			user_id = parseInt(data['id'], 10);
			$.ajax({
				type: 'POST',
				url: 'ideas.php',
				data: {id: , userid: user_id, title: $("#title").val(), tweet: $("#tweet").val(), 
					description: $("#description").val(), genre: $("#genre").val()},
				dataType: 'json',
				success: function(data){
					alert("ran through");
				},
				error: function(data, error){
					console.debug(data);
					console.debug(error);
				}

			});
		},
		error: function(data, error){
			console.debug(data);
			console.debug(error);
		}
	});
});*/

function getCookie(c_name){
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1){
		c_start = c_value.indexOf(c_name + "=");
	} if (c_start == -1) {
		c_value = null;
	} else {
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1) {
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}