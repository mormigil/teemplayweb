
function voted(id){
	$('.vote').remove();
	var total = 0;
	var percent = 0;
	var votes = new Array();
	$.ajax({
		type: 'GET',
		url: 'ideas.php',
		dataType: 'json',
		success: function(data){
			for(var i=0; i<9; i++){
				total = total + data[i].votes;
				votes[i] = data[i].votes;
			}
			for(var i = 0; i<9; i++){
				percent = Math.round(100*data[i].votes/total);
				$("#changeable"+(i+1)).append("<p class = 'vote'>"+percent + "%</p>");
			}
		},
		error: function(data, error){
        console.debug(data); 
        console.debug(error);
    	}
    	
	});
/*
	$.get("ideas.php", function(data) {
		total = data[0].votes;
		alert("data loaded" + total);
	}, "json");*/
}

$(document).ready(function(){
	var c_value = document.cookie;

	var c_start = c_value.indexOf(" onevote=");
	if (c_start == -1)
  	{
  		c_start = c_value.indexOf("onevote=");
  	}
	if (c_start == -1)
  	{
  		c_value = null;
  	}
	else
  	{
  		c_start = c_value.indexOf("=", c_start) + 1;
  		var c_end = c_value.indexOf(";", c_start);
  	if (c_end == -1)
  	{
		c_end = c_value.length;
	}
	c_value = unescape(c_value.substring(c_start,c_end));
	}
	if(c_value!=null){
		c_value = parseInt(c_value);
		voted(c_value);
	}
});

$(document).on('click', '.vote', function(){
	$.post("ideas.php", {id: $(this).val()}, function(data){

	}, "json");
	alert("Thank you for your vote please come back tomorrow to cast another!");
	voted($(this).val());
});