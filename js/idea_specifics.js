$(document).ready(function(){
	$(function(){
		$( "#tabs" ).tabs();
	});
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var user_id = getCookie('username');
	if(id=='idea_detailed.php'||id===''){
		window.location.replace("http://localhost/teemplayweb/idea_viewing.php");
	}
	else{
		$.get("http://localhost/teemplayweb/votes.php", {userid:user_id}, function(data){
			idea_ids = data;
			$.get('http://localhost/teemplayweb/ideas.php/'+id, function(data){
				var stage = data['stage'];
				//find a way to remove links if the link number is greater than stage
				//	$("#"+stage > a).remove();

				for(var j = 0; j<idea_ids.length; j++){
					if(data['id']==idea_ids[j]['ideaid']){
						$("#idea_info").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
						"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
						"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
						data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
						"' class = 'voted' id = 'voted"+data["id"]+"'>"+"voted</button></div></div>");
						break;
					}
				}
				if(j==idea_ids.length){
					$("#idea_info").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
					"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
					"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
					data["description"]+"</p></div><div class = 'voteArea'><button value = '"+data['id']+
					"' class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button></div></div>");
				}
			}, 'json');
		}, 'json');

		//add in the influence information, a place to add a new influence and a place to see current 
		//influences and vote on them along with a link to a plain voting hub
		$.get('http://localhost/teemplayweb/votes_influence.php', {userid:user_id}, function(data){
			influence_ids = data;
			$.get("http://localhost/teemplayweb/influences.php/"+id, function(data){
				//add specific instances of influence.
			}, 'json');
		}, 'json');
	}
});

$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("http://localhost/teemplayweb/votes.php", {ideaid: $(this).val(), userid: userid}, function(){
		alert("voted!");
	});
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