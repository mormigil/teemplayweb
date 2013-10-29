$(document).ready(function(){
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-1];

	var user_id = getCookie('username');
	if(id=='inspiration_detailed.php'||id===''){
		window.location.replace("http://localhost/teemplayweb/inspiration_viewing.php");
	}
	else{
		$.get("http://localhost/teemplayweb/votes.php", {type: 3, userid:user_id}, function(data){
			inspiration_ids = data;
			$.get("http://localhost/teemplayweb/inspirations.php/"+id, function(data){
				//**NOTE probably a faster way to do this -- come back for more elegant solution
				//need to run through the ideas to see if it has been voted on already
				for(var j = 0; j<inspiration_ids.length; j++){
					if(data['id'] == inspiration_ids[j]['linkedid']){
						//if it has append the voted section
						appendVoted(data);
						break;
					}
				}
				//if there was no evidence of a vote
				if(j==inspiration_ids.length){
					//append the vote section
					appendVote(data);
				}
			}, 'json');
		}, 'json');
	}
});

function appendVote(data){
	$("#text_description").append("<div class = 'description'><p>"+
	data["description"]+"</p></div>");

	$("#author_info").append("<div class = 'author'><p>"+data["userid"]+"</p></div>");

	$("#actions").append("<div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'vote' id = 'vote"+data["id"]+"'>"+"vote</button>");

	if(isset(data['pic'])){
		//add an image with the local url from uploaded
	}
	else if(isset(data['vid'])){
		//add a video with the local url
	}
	else if(isset(data['url'])){
		//add image from the url as main image
	}
	else{
		//add tweet or some small text as main picture content
	}
}

function appendVoted(data){
	$("#text_description").append("<div class = 'description'><p>"+
	data["description"]+"</p></div>");

	$("#author_info").append("<div class = 'author'><p>"+data["userid"]+"</p></div>");

	$("#actions").append("<div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'voted' id = 'voted"+data["id"]+"'>"+"voted</button>");
	if(isset(data['pic'])){
		//add an image with the local url from uploaded
	}
	else if(isset(data['vid'])){
		//add a video with the local url
	}
	else if(isset(data['url'])){
		//add image from the url as main image
	}
	else{
		//add tweet or some small text as main picture content
	}
}