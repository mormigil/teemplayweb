$(document).ready(function(){
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var user = getCookie('username');
	loadInspirations(user, id);
});

function loadInspirations(user, id){
	user_id = user;
	$.get("http://localhost/teemplayweb/votes.php", {type: 3, userid:user_id}, function(data){
		inspiration_ids = data;
		if(id == 'inspiration_viewing.php'){
			$.get("inspirations.php", function(data){
				//**NOTE probably a faster way to do this -- come back for more elegant solution
				//need to run through the ideas to see if it has been voted on already
				for(var i = 0; i<data.length; i++){
					for(var j = 0; j<inspiration_ids.length; j++){
						if(data[i]['id'] == inspiration_ids[j]['linkedid']){
							inspiration = data[i];
							//if it has append the voted section
							appendVoted(inspiration);
							break;
						}
					}
					//if there was no evidence of a vote
					if(j==inspiration_ids.length){
						inspiration = data[i];
						//append the vote section
						appendVote(inspiration);
					}
				}
			}, 'json');
		}
		//load individual inspirations
		else{
			$.get("http://localhost/teemplayweb/inspirations.php/"+id, function(data){
				for(var j = 0; j<inspiration_ids.length; j++){
					if(data['id'] == inspiration_ids[j]['linkedid']){
						appendVoted(data);
						break;
					}
				}
				if(j==inspiration_ids.length){
					appendVote(data);
				}
			}, 'json');
		}
	}, 'json');
}

$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("votes.php", {linkedid: $(this).val(), userid: userid, type: 3}, function(){
		alert("voted!");
	});
});

function appendVote(data){
	$("#inspirations").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
	"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
	"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
	data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button><a href = 'inspiration_detailed.php/"+
	data['id']+"'>More Info</a></div></div>");
}

function appendVoted(data){
	$("#inspirations").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
	"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
	"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
	data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'voted' id = 'voted"+data["id"]+"'>"+"voted</button><a href = 'inspiration_detailed.php/"+
	data['id']+"'>More Info</a></div></div>");
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