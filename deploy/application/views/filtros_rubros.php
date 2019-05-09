<div class="dialog-msg"></div>

<script type="text/javascript">
	
	var selectedPersona;

	$(".persona").click(function()
	{
		selectedPersona	= $( this ).data('personaid');
		
		$( '.selectedPersona').removeClass('selectedPersona');
		$( this ).addClass('selectedPersona');

		$('.selectCuenta').hide();

		
		var element = '#persona-' + $( this ).data('personaid');
		$( element ).show();
	
	});

	$(".cuenta").click(function()
	{
		if ( $(this).hasClass( "selectedCuenta" ) )
		{
			$( this ).removeClass('selectedCuenta');
		}
		else
		{
			$( this ).addClass('selectedCuenta');
		}
	});
	
	function sendFiltros()
	{
		var rubrosSelected = new Array();
		var count = 0;
		
		$( ".selectedCuenta" ).each(function()
		{
			//console.log( $( this ).data('cuentaid') );
			
			rubrosSelected[count] = $( this ).data('cuentaid');
			
			count++;
		});


		$.ajax({
			method: "POST",
			url: "<?=base_url('index.php/filtros')?>/setRubros/",
			data: { rubrosActivo: JSON.stringify(rubrosSelected) }
		})
		.done(function( msg ) {
			
			// [Todo] No sé porqué la parte del JSON anda mal.
			//alert(msg);
			
			var jsonObj = JSON.parse( msg );
	
			if ( jsonObj.refresh == true )
			{
				refrescar();
			}
		});
	}
	
	function selectTodos()
	{
		$( '#persona-' + selectedPersona +' li' ).addClass('selectedCuenta');
	}

	function selectNinguno()
	{
		$( '#persona-' + selectedPersona +' li' ).removeClass('selectedCuenta');
	}
	
</script>

<?
// Personas

//print_r($sessionRubrosArray);

?>
<ul class="selectPersona">
	<?
		foreach ( $rubroArray as $personas )
		{
			?><li class="persona <?=$personas['object']->color?> tab_<?=$personas['object']->unique_name?>" data-personaid="<?=$personas['object']->id?>">
				<img src="<? echo base_url( "assets/img/" . $personas['object']->unique_name )?>.png" /><br/>
				<span><?=$personas['object']->nombre?></span>
			</li><?
		}
	?>
</ul>

<?
// Rubros	
foreach ( $rubroArray as $personas )
{
	?>
	<ul id="persona-<?=$personas['object']->id?>" style="display: none;" class="selectCuenta">
		<?
		foreach ( $personas['cuentas'] as $cuentas )
		{
			$selectedCuenta = ( isset($sessionRubrosArray[$cuentas->rubro_id]) && $sessionRubrosArray[$cuentas->rubro_id] ) ? ' selectedCuenta' : '';
			
			?><li class="cuenta<?=$selectedCuenta?>" data-cuentaid="<?=$cuentas->rubro_id?>"><?=$cuentas->nombre?></li><?
		}
		?>
	</ul>
	<?
}
?>

<script type="text/javascript">
	
	
	$('.tab_<?=$persona?>').click();
	
</script>