function dateToText(timeLeft){
	negative = 1;
	if(timeLeft<0){
		negative = -1;
		timeLeft = -timeLeft;
	}
	days = Math.floor(timeLeft/86400);
	hours = Math.floor((timeLeft-(days*86400))/3600);
	mins = Math.floor((timeLeft-(days*86400)-(hours*3600))/60);
	secs = Math.floor(timeLeft-(days*86400)-(hours*3600)-(mins*60));
	date = negative*days + " days " + hours + " hours " + mins +
	" minutes " + secs + " seconds left";
	return date;
}

function appendVote(data, stages, stages2){
	timeLeft = data["timeleft"];
	dateString = dateToText(timeLeft);
	$("#ideas").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
	"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
	"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
	data["description"]+"</p></div><div class = 'timeleft'><p>"+dateString+
	"</p></div><div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button><a href = 'idea_detailed.php/"+
	data["id"]+stages[data["stage"]]+stages2[data["stage"]]+"'>More Info</a></div></div>");
}

function appendVoted(data, stages, stages2){
	timeLeft = data["timeleft"];
	dateString = dateToText(timeLeft);
	$("#ideas").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
	"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
	"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
	data["description"]+"</p></div><div class = 'timeleft'><p>"+dateString+
	"</p></div><div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'voted' id = 'voted"+data["id"]+"'>"+"voted</button><a href = 'idea_detailed.php/"+
	data["id"]+stages[data["stage"]]+stages2[data["stage"]]+"'>More Info</a></div></div>");
}

function loadIdeas(user, id){
	var stages2 = ["#idea_misc", "#story", "#character", "#art", "#mechanics", "#levels",
		"#price", "#distribution"];
	var stages = ["/idea_misc", "/story", "/character", "/art", "/mechanics", "/levels",
		"/price", "/distribution"];
	user_id = user;

	//submitted ideas location for the first 30 days
	$.get("http://localhost/teemplayweb/votes.php", {type: 1, userid:user_id}, function(data){
		idea_ids = data;
		if(id == 'idea_viewing.php'){
			$.get("ideas.php", function(data){
				//**NOTE probably a faster way to do this -- come back for more elegant solution
				//need to run through the ideas to see if it has been voted on already
				for(var i = 0; i<data.length; i++){
					for(var j = 0; j<idea_ids.length; j++){
						if(data[i]['id']==idea_ids[j]['linkedid']){
							idea = data[i];
							//if it has append the voted section
							appendVoted(idea, stages, stages2);
							break;
						}
					}
					//if there was no evidence of a vote
					if(j==idea_ids.length){
						idea = data[i];
						//append the vote section
						appendVote(idea, stages, stages2);
						}
				}
			}, 'json');
		}

		//ideas in the project phase being loaded
		else if(id=='project_viewing.php'){
			$.get("ideas.php", {current:true}, function(data){
				for(var i = 0; i<data.length; i++){
					for(var j = 0; j<idea_ids.length; j++){
						if(data[i]['id']==idea_ids[j]['linkedid']){
							idea = data[i];
							appendVoted(idea, stages, stages2);
							break;
						}
					}
					if(j==idea_ids.length){
						idea = data[i];
						appendVote(idea, stages, stages2);
					}
				}
			}, 'json');
		}

		//individual ideas being loaded
		else{
			$.get('http://localhost/teemplayweb/ideas.php/'+id, function(data){
			for(var j = 0; j<idea_ids.length; j++){
					if(data['id']==idea_ids[j]['linkedid']){
						appendVoted(data, stages, stages2);
						break;
					}
				}
				if(j==idea_ids.length){
					appendVote(data, stages, stages2);
				}
			}, 'json');
		}
	}, 'json');
}

$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("votes.php", {linkedid: $(this).val(), userid: userid, type: 1}, function(){
		alert("voted!");
	});
});

$(document).ready(function(){
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];
	var user = getCookie('username');
	loadIdeas(user, id);
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