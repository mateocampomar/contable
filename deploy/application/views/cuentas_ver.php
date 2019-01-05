	<div class="bdy-container">
		<ul class="cuenta-menu">
			<li>
				<div role="main" class="ui-content">
			    	<a href="#dialogPage" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_plus.png')?>" /></a>
				</div>
			</li>
		</ul>
		<h1><?=$cuentaObj->nombre?> <span style="font-weight: normal;">(<?=$cuentaObj->moneda?>)</span></h1>
		<div class="ver-cuenta">
			<table border="0" cellpadding="0" cellspacing="1" class="tabla">
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
							<td style="font-weight: bold;"><?=$movimientosObj->concepto?></td>
							<td>
								<?									
									if ( $movimientosObj->persona_id && $movimientosObj->rubro_id )
									{
										?>
										<span class="tag-rubro <?=$movimientosObj->color?>">
											<a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink">
												<img src="<? echo base_url( "assets/img/" . $movimientosObj->unique_name )?>.png" /> <?=$movimientosObj->nombre?>
											</a>
										</span>
										<?
									}
									else
									{
										?><a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink">?</a><?
									}
								?>
							</td>
							<td align="right"><?=formatNumberCustom( $movimientosObj->credito )?></td>
							<td align="right"><?=formatNumberCustom( $movimientosObj->debito )?></td>
							<td align="right"><strong><?=formatNumberCustom( $movimientosObj->saldo )?></strong></td>
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
		$('#importar_datos').button('disable');
		$('#btn_parsernot').button('disable');

			
		$.ajax({
			method: "POST",
			url: "<?=base_url('index.php/cuentas/parser/')?>",
			data: { cuentaId: "<?=$cuentaObj->id?>", inputTxt: $('#inputTxt').val() }
		})
		.done(function( msg ) {
			
			var jsonObj = jQuery.parseJSON( msg );
			
			if ( jsonObj.error == false )
			{
				$( "#inputTxt" ).val('');
				$( "#inputTxt" ).addClass( "statusok" );
				
				window.setTimeout(function(){

					window.location.replace("<?=base_url('index.php/cuentas/ver/' . $cuentaObj->id )?>");

                }, 1500);

			}
			else
			{
				$('#importar_datos').button('enable');
				$('#btn_parsernot').button('enable');

				alert( "ERROR: " + jsonObj.errorTxt );
			}
		});
	}

	function sendToRubrar( movimientoId )
	{
		$.ajax({
			method: "POST",
			url: "<?=base_url('index.php/cuentas/rubrar')?>/" + movimientoId,
		})
		.done(function( msg ) {
			
			var jsonObj = jQuery.parseJSON( msg );

			$("#rubrar-container").html( jsonObj.html );
		});
	}

	$(".rubradoLink").click(function()
	{
		sendToRubrar( $( this ).data('movimientoid') );
	});

</script>

<div data-role="page" id="dialogPage">
  <div role="main" class="ui-content">
	<h2>Importar Cuenta</h2>
	<div class="dialog-msg"></div>
    <textarea id="inputTxt" style="height: 300px; width: 100%" data-role="none"></textarea>
    <br/><br/>
    <a href="javascript:sendToParser();" data-role="button" data-theme="b" id="importar_datos">Importar Datos</a>
    <a href="" data-role="button" data-rel="back" data-theme="a" id="btn_parsernot">Not!</a>
  </div>
</div>

<div data-role="page" id="dialogPageRubrado">
  <div role="main" class="ui-content">
    <div class="rubrar-container loading" id="rubrar-container"></div>
    <a href="javascript:sendRubrado();" data-role="button" data-theme="b">Asignar Rubro a Movimiento</a>
    <a href="" data-role="button" data-rel="back" data-theme="a" class="btn_not">Not!</a>
  </div>
</div>

<div>