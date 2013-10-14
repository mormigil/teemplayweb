$(document).ready(function(){
	$(function(){
		$( "#tabs" ).tabs();
	});
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var hash = window.location.hash;
	var hashNum = getHashNumber(hash);
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
			var influence_ids = new Array();
			//grab all the influence ids that the user has already voted on
			for(var i = 0; i<data.length; i++){
				influence_ids[i] = data[i]["influenceid"];
			}
			//if there are no influences blacklist should still pass through as null
			if(influence_ids[0]===null||influence_ids[0]===undefined){
				influence_ids = null;
			}
			$.get("http://localhost/teemplayweb/influences.php", {ideaid:id, type:hashNum, blacklist:influence_ids}, function(data){
				for(var i = 0; i<3; i++){
					if(i>=data.length){
						break;
					}
					//have 3 current pieces of influence shown
					$(hash).append("<div class = 'inf_box' id = 'inf_box"+data[i]["id"]+
					"'><div class = 'title'>"+"<h2>"+data[i]["title"]+"</h2></div><div class = 'author'><p>"+
					data[i]["userid"]+"</p></div><div class = 'description'><p>"+data[i]["description"]+
					"</p></div><div class = 'voteArea'><button value = '"+data[i]['id']+
					"' class = 'vote_inf' id = 'vote_inf"+data[i]["id"]+"'>"+"vote</button></div></div>");
				}
				//Have a way to submit a piece of influence for the current stage
				$(hash).append("<div class = 'submit'><a href = '../influence_submission.php/"+id+"#"+hashNum+"'>Submit"+
					" your own idea</a></div>");
			}, 'json');
		}, 'json');
	}
});

//vote for the idea
$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("http://localhost/teemplayweb/votes.php", {ideaid: $(this).val(), userid: userid}, function(){
		alert("voted!");
	});
});

//vote for a particular influence
$(document).on("click", ".vote_inf", function(){
	var userid = getCookie('username');
	$.post("http://localhost/teemplayweb/votes_influence.php", {ideaid: $(this).val(), userid: userid}, function(){
		alert("voted!");
	});
});

//match the stage description with its number
function getHashNumber(hash){
	var stages = ["#idea_misc", "#story", "#character", "#art", "#mechanics", "#levels", "#price", "#distribution"];
	for(var i = 0; i<8; i++){
		if(hash === stages[i]){
			return i;
		}
	}
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