<h2>
	<?
		
	echo $movimientoObj->nombre?> <strong style="font-weight: normal;">(<?=$movimientoObj->moneda?>)</strong><?
	
	if ( $movimientoObj->debito >= 0 )
	{
		?><span style="color:red;"><i><?=$movimientoObj->simbolo?></i> -<?=$movimientoObj->debito?></span><?
	}
	else
	{
		?><span style="color:green;"><i><?=$movimientoObj->simbolo?></i> <?=$movimientoObj->credito?></span><?
	}
	
	?>	
</h2>

<p>
	<?=$movimientoObj->concepto?><br/>
	<span><?=$movimientoObj->fecha?></span>
</p>

<div class="dialog-msg"></div>

<script type="text/javascript">
	
	var selectedPersona;
	var selectedRubro;

	$(".persona").click(function()
	{
		selectedPersona	= $( this ).data('personaid');
		
		$( '.selectedPersona').removeClass('selectedPersona');
		$( this ).addClass('selectedPersona');
		

		$( '.selectedCuenta').removeClass('selectedCuenta');
		$('.selectCuenta').hide();

		
		var element = '#persona-' + $( this ).data('personaid');
		$( element ).show();
	
	});

	$(".cuenta").click(function()
	{
		selectedRubro	= $( this ).data('cuentaid');

		$( '.selectedCuenta').removeClass('selectedCuenta');

		$( this ).addClass('selectedCuenta');

	
	});
	
	function sendRubrado()
	{
		if ( selectedPersona &&  selectedRubro )
		{
			$.ajax({
				method: "POST",
				url: "<?=base_url('index.php/cuentas/setRubro/')?>",
				data: { movimientoId: <?=$movimientoObj->id?>, personaId: selectedPersona, rubroId: selectedRubro }
			})
			.done(function( msg ) {
				alert( "Data Saved: " + msg );
			});
		}
		else
		{
			alert( 'Seleccioná una cuenta y una persona' );
		}
	}

	
</script>


<ul class="selectPersona">
	<?
		foreach ( $rubroArray as $personas )
		{
			?><li class="persona <?=$personas['object']->color?>" data-personaid="<?=$personas['object']->id?>">
				<img src="<? echo base_url( "assets/img/" . $personas['object']->unique_name )?>.png" /><br/>
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
				?><li class="cuenta" data-cuentaid="<?=$cuentas->rubro_id?>"><?=$cuentas->nombre?></li><?
			}
			?>
		</ul>
		<?
	}