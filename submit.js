$(document).ready(function(){
	var c_value = document.cookie;

	var c_start = c_value.indexOf(" onevote=");
	if(c_start==-1){
		c_start = c_value.indexOf("onevote=");
	}
});