$(document).ready(function(){
	window.scrollTo(0,0);
	var pathArray = window.location.pathname.split('/');
	var id = pathArray[pathArray.length-2];
	var stageName = pathArray[pathArray.length-1];
	var stageNum = getStageNumber(stageName);
	$(function(){
		$( "#tabs" ).tabs({
			selected: stageNum
		});
	});

	var user_id = getCookie('username');
	if(id=='project_detailed.php'||id===''||id=='teemplayweb'||stageName===''){
		window.location.replace("http://localhost/teemplayweb/project_viewing.php");
	}
	else{
		$.get("http://localhost/teemplayweb/votes.php", {userid:user_id, type:1}, function(data){
			idea_ids = data;
			$.get('http://localhost/teemplayweb/ideas.php/'+id, function(data){
				//making it so that the stage is actually correct and if it isn't it corrects itself
				var stage = data['stage'];
				var stageTitle = getStageName(stage);
				var disabledStages = new Array();
				for(var i = 1; i<(8-stage); i++){
					disabledStages[i] = stage+i;
				}
				if(stageName!==stageTitle){
					window.location.replace("../"+id+"/"+stageTitle);
				}
				//disables the tabs that haven't been reached yet
				$("#tabs").tabs("option", "disabled", disabledStages);
				for(var j = 0; j<idea_ids.length; j++){
					if(data['id']==idea_ids[j]['linkedid']){
						append(data);
						break;
					}
				}
				if(j==idea_ids.length){
					append(data);
				}
			}, 'json');
		}, 'json');
		//add in the influence information, a place to add a new influence and a place to see current 
		//influences and vote on them along with a link to a plain voting hub
		$.get('http://localhost/teemplayweb/votes.php', {userid:user_id, type: 2}, function(data){
			var influence_ids = new Array();
			//grab all the influence ids that the user has already voted on
			//should be rewritten so all the data is passed at once and then the 
			//get will be a call that will just return all the influences associated
			//with the idea and type
			$.ajax({
				type: 'GET',
				url: "http://localhost/teemplayweb/influences.php",
				data: {influences: data, type: stageNum, ideaid:id},
				dataType: 'json',
				success: function(data){
					for(var i = 0; i<data.length; i++){
						influence_ids[i] = data[i]['id'];
					}
					$.get("http://localhost/teemplayweb/influences.php", {ideaid:id, type:stageNum, blacklist:influence_ids}, function(data){
						for(var i = 0; i<3; i++){
							if(i>=data.length){
								break;
							}
							//have 3 current pieces of influence shown
							tempStage = stageName;
							influence = data[i];
							appendInf(influence, tempStage);
							}
					}, 'json');
					$("#"+stageName).addClass("height");
				},
				error: function(data){
					$.get("http://localhost/teemplayweb/influences.php", {ideaid:id, type:stageNum, blacklist:5}, function(data){
						for(var i = 0; i<3; i++){
							if(i>=data.length){
								break;
							}
							//have 3 current pieces of influence shown
							tempStage = stageName;
							influence = data[i];
							appendInf(influence, tempStage);
							}
					}, 'json');
					$("#"+stageName).addClass("height");
				}
			});
			
			//Have a way to submit a piece of influence for the current stage
				$("#"+stageName).append("<div class = 'submit'><a href = 'http://localhost/teemplayweb/influence_submission.php/"+id+"#"+stageNum+"'>Submit"+
					" your own idea</a></div>");
		}, 'json');
		//have a get to add winners onto old stages
		$.get("http://localhost/teemplayweb/influences.php", {ideaid:id, type:stageNum}, function(data){
			for(var i = 0; i<stageNum; i++){
				tempStage = getStageName(i);
				influence = data[i];
				appendInf(influence, tempStage);
				}
		}, 'json');
	}
});

//vote for the idea
$(document).on("click", ".vote", function(){
	var userid = getCookie('username');
	$.post("http://localhost/teemplayweb/votes.php", {linkedid: $(this).val(), userid: userid, type:1}, function(){
		alert("voted!");
	});
});

//vote for a particular influence
$(document).on("click", ".vote_inf", function(){
	var userid = getCookie('username');
	$.post("http://localhost/teemplayweb/votes.php", {linkedid: $(this).val(), userid: userid, type:2}, function(){
		alert("voted!");
	});
});

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

function append(data){
	timeLeft = data["timeleft"];
	dateString = dateToText(timeLeft);
	$("#idea_info").append("<div class = 'box' id = 'box" +data["id"]+ "'><div class = 'title'>"+
	"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+data["userid"]+"</p></div>"+
	"<div class = 'tweet'><p>"+data["tweet"]+"</p></div><div class = 'description'><p>"+
	data["description"]+"</p></div><div class = 'timeleft'><p>"+dateString+
	"</p></div></div>");
}

function appendInf(data, stage){
	$("#"+stage).append("<div class = 'inf_box' id = 'inf_box"+data["id"]+
	"'><div class = 'title'>"+"<h2>"+data["title"]+"</h2></div><div class = 'author'><p>"+
	data["userid"]+"</p></div><div class = 'description'><p>"+data["description"]+
	"</p></div><div class = 'voteArea'><button value = '"+data['id']+
	"' class = 'vote_inf' id = 'vote_inf"+data["id"]+"'>"+"vote</button></div></div>");
			
}

//match the stage description with its number
function getStageNumber(stage){
	var stages = ["idea_misc", "story", "character", "art", "mechanics", "levels", "price", "distribution"];
	for(var i = 0; i<8; i++){
		if(stage === stages[i]){
			return i;
		}
	}
}

function getStageName(stage){
	var stages = ["idea_misc", "story", "character", "art", "mechanics", "levels", "price", "distribution"];
	return stages[stage];
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