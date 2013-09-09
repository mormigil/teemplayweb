$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: 'ideas.php',
		dataType: 'json',
		success: function(data){
			for(var i = 0; i<data.length; i++){
				$("#ideas").append("<div class = 'box' id = 'box" +data[i]["id"]+ "'><div class = 'title'>"+
					"<h2>"+data[i]["title"]+"</h2></div><div class = 'author'><p>"+data[i]["userid"]+"</p></div>"+
					"<div class = 'tweet'><p>"+data[i]["tweet"]+"</p></div><div class = 'description'><p>"+
					data[i]["description"]+"</p></div><div class = 'vote'><button id = 'vote"+data[i]["id"]+"'>"+
					"</button></div></div>");
			}
		},
		error: function(data, error){
			console.debug(data);
			console.debug(error);
		}
	});

});