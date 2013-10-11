function loadIdeas(user, id){
	var stages = ["#idea_misc", "#story", "#character", "#art", "#mechanics", "#levels",
		"#price", "#distribution"];
	user_id = user;
	$.get("http://localhost/teemplayweb/votes.php", {userid:user_id}, function(data){
		idea_ids = data;
		if(id == 'idea_viewing.php'){
			$.get("ideas.php", function(data){
				for(var i = 0; i<data.length; i++){
					for(var j = 0; j<idea_ids.length; j++){
						if(data[i]['id']==idea_ids[j]['ideaid']){
							$("#ideas").append("<div class = 'box' id = 'box" +data[i]["id"]+ "'><div class = 'title'>"+
							"<h2>"+data[i]["title"]+"</h2></div><div class = 'author'><p>"+data[i]["userid"]+"</p></div>"+
							"<div class = 'tweet'><p>"+data[i]["tweet"]+"</p></div><div class = 'description'><p>"+
							data[i]["description"]+"</p></div><div class = 'voteArea'><button value = '"+data[i]['id']+
							"' class = 'voted' id = 'voted"+data[i]["id"]+"'>"+"voted</button><a href = 'idea_detailed.php/"+
							data[i]["id"]+stages[data[i]["stage"]]+"'>More Info</a></div></div>");
							break;
						}
					}
					if(j==idea_ids.length){
						$("#ideas").append("<div class = 'box' id = 'box" +data[i]["id"]+ "'><div class = 'title'>"+
						"<h2>"+data[i]["title"]+"</h2></div><div class = 'author'><p>"+data[i]["userid"]+"</p></div>"+
						"<div class = 'tweet'><p>"+data[i]["tweet"]+"</p></div><div class = 'description'><p>"+
						data[i]["description"]+"</p></div><div class = 'voteArea'><button value = '"+data[i]['id']+
						"' class = 'vote' id = 'vote"+data[i]["id"]+"'>"+"vote</button><a href = 'idea_detailed.php/"+
							data[i]["id"]+stages[data[i]["stage"]]+"'>More Info</a></div></div>");
					}
				}
			}, 'json');
		}
		else{
			$.get('http://localhost/teemplayweb/ideas.php/'+id, function(data){
			for(var j = 0; j<idea_ids.length; j++){
					if(data['id']==idea_ids[j]['ideaid']){
						$("#ideas").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
						"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
						"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
						data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
						"' class = 'voted' id = 'voted"+data["id"]+"'>"+"voted</button><a href = "+
						"'http://localhost/teemplayweb/idea_detailed.php/"+data[i]["id"]+stages[data[i]["stage"]]+
						"'>More Info</a></div></div>");
						break;
					}
				}
				if(j==idea_ids.length){
					$("#ideas").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
					"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
					"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
					data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
					"' class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button><a href = "+
						"'http://localhost/teemplayweb/idea_detailed.php/"+data[i]["id"]+stages[data[i]["stage"]]+
						"'>More Info</a></div></div>");
				}
			}, 'json');
		}
	}, 'json');
}

$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("votes.php", {ideaid: $(this).val(), userid: userid}, function(){
		alert("voted!");
	});
});

$(document).ready(function(){
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var user = getCookie('username');
	loadIdeas(user, id);
	//request without a path query
	/*
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
	checkVoted(user);*/
});

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