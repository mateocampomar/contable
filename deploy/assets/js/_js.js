var DELAY = 500, clicks = 0, timer = null, thisObjPersona = null;


$(".rubradoLink").click(function()
{
	alert('click');
});

function getConfigYear( elem )
{
	//alert(elem.value);
	
	window.location.replace("/index.php/config/set_config_year/" + elem.value);
}