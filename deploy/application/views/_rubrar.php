<h2>
	<?
		
	echo $movimientoObj->nombre?> <strong style="font-weight: normal;">(<?=$movimientoObj->moneda?>)</strong><?
	
	if ( $movimientoObj->debito )
	{
		?><span style="color:red;"><?=$movimientoObj->debito?></span><?
	}
	else
	{
		?><span style="color:green;"><?=$movimientoObj->creito?></span><?
	}
	
	?>	
</h2>

<p><?=$movimientoObj->concepto?></p>

<div class="dialog-msg"></div>

<script type="text/javascript">

	$(".persona").click(function()
	{
		$( '.selectedPersona').removeClass('selectedPersona');
		$( this ).addClass('selectedPersona');
		

		$( '.selectedCuenta').removeClass('selectedCuenta');
		$('.selectCuenta').hide();

		
		var element = '#persona-' + $( this ).data('personaid');
		$( element ).show();
	
	});

	$(".cuenta").click(function()
	{

		$( '.selectedCuenta').removeClass('selectedCuenta');
		
		$( this ).addClass('selectedCuenta');

	
	});
	
	function sendRubrado()
	{
		alert('ok');
	}

	
</script>


<ul class="selectPersona">
<?
	foreach ( $rubroArray as $personas )
	{
		?><li class="persona <?=$personas['object']->color?>" data-personaid="<?=$personas['object']->id?>">
			<img src="<?=$personas['object']->unique_name?>" /><br/>
			<span><?=$personas['object']->nombre?></span>
		</li><?
	}
?>
</ul>



<?
foreach ( $rubroArray as $personas )
{
	?>
	<ul id="persona-<?=$personas['object']->id?>" style="display: none;" class="selectCuenta">
		<?
		foreach ( $personas['cuentas'] as $cuentas )
		{
			?><li class="cuenta"><?=$cuentas->nombre?></li><?
		}
		?>
	</ul>
	<?
}