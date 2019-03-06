<script type="text/javascript">

	<?
	if ( !$multicuenta )
	{
		?>
		function sendToParser()
		{
			//$('#importar_datos').button('disable');
			//$('#btn_parsernot').button('disable');
				
			$.ajax({
				method: "POST",
				url: "<?=base_url('index.php/cuentas/parser/')?>",
				data: { cuentaId: "<?=$cuentasArray[0]?>", inputTxt: $('#inputTxt').val() }
			})
			.done(function( msg ) {
				
				var jsonObj = jQuery.parseJSON( msg );
				
				if ( jsonObj.error == false )
				{
					$( "#inputTxt" ).val('');
					$( "#inputTxt" ).addClass( "statusok" );
					
					window.setTimeout(function(){
	
						refrescar();
	
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
		
		function refrescar()
		{
			window.location.replace("<?=base_url('index.php/cuentas/ver/' . $cuentasArray[0] )?>");
		}

		function sendToTransferir()
		{
			if ( !$('#tp_depersona').val() )								{ alert('Ingresá el DE:');						return false; }
			
			if ( !$('#tp_parapersona').val() )								{ alert('Ingresá el PARA:');					return false; }
			
			if ( $('#tp_depersona').val() == $('#tp_parapersona').val() )	{ alert('DE: y PARA: no pueden ser iguales.'); 	return false; }
			
			if ( !$('#tp_monto').val() )									{ alert('Ingresá un monto.');					return false; } // [TODO] Debe ser un número.


			//$('#importar_datos').button('disable');
			//$('#btn_parsernot').button('disable');

				
			$.ajax({
				method: "POST",
				url: "<?=base_url('index.php/cuentas/transferir_persona/')?>",
				data: {
					de_persona: $('#tp_depersona').val(),
					para_persona: $('#tp_parapersona').val(),
					montoNbr: $('#tp_monto').val(),
					conceptoTxt: $('#tp_concepto').val(),
					cuentaId: "<?=$cuentasArray[0]?>"
				}
			})
			.done(function( msg ) {
				
				var jsonObj = jQuery.parseJSON( msg );


				if ( jsonObj.error == false )
				{
					// [TODO] Falta el mensaje de ok.

					//$( "#inputTxt" ).val('');
					//$( "#inputTxt" ).addClass( "statusok" );
					//window.setTimeout(function(){
						refrescar();
	                //}, 1500);
	
				}
				else
				{
					$('#btn_transferir').button('enable');
					$('#btn_tt_not').button('enable');
	
					alert( "ERROR: " + jsonObj.errorTxt );
				}
			});
		}

		<?
	}
	?>
</script>

<div data-role="page" id="dialogPage">
	<div role="main" class="ui-content">
		<h2 class="importar_cuenta"><img src="<?=base_url('assets/img/icon_plus.png')?>" /> Importar Cuenta</h2>
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
		<a href="javascript:refrescar();" data-role="button" data-theme="a" class="btn_not">Not!</a>
	</div>
</div>

<div data-role="page" id="dialogPageTransfer">
	<div role="main" class="ui-content">
		<div class="transfer-container loading" id="transfer-container">
			<h2 class="importar_cuenta"><img src="<?=base_url('assets/img/icon_transfer.png')?>" />Transferencias entre Personas</h2>
			<div class="dialog-msg"></div>
			<div>
				<br/>
				<select id="tp_depersona">
				  <option value="">De:</option>
				  <?
					foreach( $personasArray as $personaObj )
					{
						?><option value="<?=$personaObj->id?>"><?=$personaObj->nombre?></option><?
					}
				  ?>
				</select>
			</div>
			<div class="divimg"><img src="<?=base_url('assets/img/icon_greenarrowdown.png')?>" width="50" /></div>
			<div>
				<select id="tp_parapersona">
				  <option value="">Para:</option>
				  <?
					foreach( $personasArray as $personaObj )
					{
						?><option value="<?=$personaObj->id?>"><?=$personaObj->nombre?></option><?
					}
				  ?>
				</select>
			</div>
			<br/>
			<br/>
			<div>Monto a Transferir: <input type="text" id="tp_monto" name="tp_monto" required minlength="4" maxlength="8" size="10"></div>
			<br/>
			<div>Concepto: <input type="text" id="tp_concepto" name="tp_concepto" required minlength="4" maxlength="8" size="10"></div>
			<br/>
		</div>
		<a href="javascript:sendToTransferir();" data-role="button" data-theme="b"id="btn_transferir">Transferir</a>
		<a href="javascript:refrescar();" data-role="button" data-theme="a" class="btn_not" id="btn_tt_not">Not!</a>
	</div>
</div>