var DELAY = 500, clicks = 0, timer = null, thisObjPersona = null;


$(".rubradoLink").click(function()
{
	alert('click');
});

function getConfigYear( elem )
{
	//alert(elem.value);
	
	//alert(url);
	
	//window.location.replace("/index.php/config/set_config_year/" + elem.value + "/" + url );
	window.location.replace("/index.php/config/set_config_year/" + elem.value );
}