<script type="text/javascript">
	
	function sendToParser()
	{
		//$('#importar_datos').button('disable');
		//$('#btn_parsernot').button('disable');

			
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
		window.location.replace("<?=base_url('index.php/cuentas/ver/' . $cuentaObj->id )?>");
	}

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