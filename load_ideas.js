$(document).ready(function(){
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var user = getCookie('username');
	//request without a path query
	if(id == 'idea_viewing.php'){
		$.ajax({
			type: 'GET',
			url: 'ideas.php',
			dataType: 'json',
			success: function(data){
				for(var i = 0; i<data.length; i++){
					$("#ideas").append("<div class = 'box' id = 'box" +data[i]["id"]+ "'><div class = 'title'>"+
						"<h2>"+data[i]["title"]+"</h2></div><div class = 'author'><p>"+data[i]["userid"]+"</p></div>"+
						"<div class = 'tweet'><p>"+data[i]["tweet"]+"</p></div><div class = 'description'><p>"+
						data[i]["description"]+"</p></div><div class = 'vote'><button value = "+data[i]['id']+
						"class = 'vote' id = 'vote"+data[i]["id"]+"'>"+"vote</button></div></div>");
				}
			},
			error: function(data, error){
				console.debug(data);
				console.debug(error);
			}
		});
	} else {
	//request with a path query
		$.ajax({
			type: 'GET',
			url: 'http://localhost/teemplayweb/ideas.php/'+id,
			dataType: 'json',
			success: function(data){
					$("#ideas").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
						"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
						"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
						data["description"]+"</p></div><div class = 'vote'><button value = "+data['id']+
						" class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button></div></div>");
			},
			error: function(data, error){
				console.debug(data);
				console.debug(error);
			}
		});
	}
	checkVoted(user);
});

function checkVoted(user){
	$.ajax({
		type: 'GET',
		url: 'users.php',
		data: {username: user},
		dataType: 'json',
		success: function(data){
			user_id = parseInt(data['id'], 10);
			var idea_ids = array();
			
		},
		error: function(data, error){
			console.debug(data);
			console.debug(error);
		}

	});
}

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