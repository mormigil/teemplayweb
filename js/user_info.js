$(document).ready(function(){
	var user_id = getCookie('username');
	$.get("http://localhost/teemplayweb/users.php", {userid: user_id}, function(data){
		$("#userinfo").append("<a href = 'http://localhost/teemplayweb/profile.php/"+data["id"]+"'><div id ='user_info'>"+
			data["username"] + "<br>" + data['level']+"</div></a>");
	}, 'json');
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