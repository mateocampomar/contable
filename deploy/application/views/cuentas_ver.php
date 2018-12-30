	<div class="bdy-container">
		<ul class="cuenta-menu">
			<li>
				<div role="main" class="ui-content">
			    	<a href="#dialogPage" data-rel="dialog" data-rel="back" data-transition="pop">+</a>
				</div>
			</li>
		</ul>
		<h1><?=$cuentaObj->nombre?> <span style="font-weight: normal;">(<?=$cuentaObj->moneda?>)</span></h1>
		<div class="ver-cuenta">
			<table border="0" cellpadding="0" cellspacing="2" class="tabla">
				<tr class="header">
					<td>Fecha</td>
					<td>Movimiento</td>
					<td align="center">Rubro</td>
					<td align="right">Crédito</td>
					<td align="right">Débito</td>
					<td align="right"><strong>Subtotal</strong></td>
				</tr>
				<?
					$trClass = "dark";
					
					foreach ( $movimientosArray as $movimientosObj )
					{
						if ( $trClass == 'dark' )	$trClass = '';
						else						$trClass = 'dark';
						
						?>
						<tr class="<?=$trClass?>">
							<td><?=$movimientosObj->fecha?></td>
							<td><?=$movimientosObj->concepto?></td>
							<td align="center">
								<?
									if ( $movimientosObj->rubro_id )
									{
										
									}
									else
									{
										?><a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->id?>" class="rubradoLink">+</a><?
									}
								?>
							</td>
							<td align="right"><?=$movimientosObj->debito?></td>
							<td align="right"><?=$movimientosObj->credito?></td>
							<td align="right"><strong><?=$movimientosObj->saldo?></strong></td>
						</tr>
						<?
					}
				?>
				</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	function sendToParser()
	{		
		$.ajax({
			method: "POST",
			url: "<?=base_url('index.php/cuentas/parser/')?>",
			data: { cuentaId: "<?=$cuentaObj->id?>", inputTxt: $('#inputTxt').val() }
		})
		.done(function( msg ) {
			alert( "Data Saved: " + msg );
		});
	}
	
	$(".rubradoLink").click(function()
	{
		//alert(  );//.data('movimientoId') );
		
		$.ajax({
			method: "POST",
			url: "<?=base_url('index.php/cuentas/rubrar/')?>",
			data: { movimientoId: $( this ).data('movimientoid') }
		})
		.done(function( msg ) {
			
			var jsonObj = jQuery.parseJSON( msg );

			$("#rubrar-container").html( jsonObj.html );
		});
	});

</script>

<div data-role="page" id="dialogPage">
  <div role="main" class="ui-content">
	<h2>Importar Cuenta</h2>
	<div class="dialog-msg"></div>
    <textarea id="inputTxt" style="height: 300px; width: 100%" data-role="none"></textarea>
    <br/><br/>
    <a href="javascript:sendToParser();" data-role="button" data-theme="b">Importar Datos</a>
    <a href="" data-role="button" data-rel="back" data-theme="a">Not!</a>
  </div>
</div>

<div data-role="page" id="dialogPageRubrado">
  <div role="main" class="ui-content">
    <div class="rubrar-container loading" id="rubrar-container"></div>
    <a href="javascript:sendRubrado();" data-role="button" data-theme="b">Asignar Rubro a Movimiento</a>
    <a href="" data-role="button" data-rel="back" data-theme="a">Not!</a>
  </div>
</div>

<div>