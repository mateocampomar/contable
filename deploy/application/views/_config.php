<div data-role="page" id="page1">
	<?=$viewLeft_menu?>
	<div class="bdy-container">
		<div class="ver-cuenta sinmenu">
			<form class="config">
				<h2>_Config</h2>
				<ul>
					<li><label><strong>Cuentas</strong></label></li>
					<li><label>&nbsp;&nbsp;<?=form_checkbox('newsletter', 'accept', TRUE, 'data-role="none"')?>&nbsp;&nbsp;Mostrar cuentas auxiliares.</label></li>
					<li><label><strong>Tarjeta de Crédito</strong></label></li>
					<li><label>&nbsp;&nbsp;<?=form_checkbox('newsletter', 'accept', TRUE, 'data-role="none"')?>&nbsp;&nbsp;Generar movimientos en personas.</label></li>
					<li><label>&nbsp;&nbsp;<?=form_checkbox('newsletter', 'accept', TRUE, 'data-role="none"')?>&nbsp;&nbsp;Generar movimiento de diferencia en pago de tarjetas.</label></li>
				</ul>
				<br/>
				<center style="width: 40%;"><?=form_submit('mysubmit', 'Submit Post!', ' data-theme="b"');?></center>
				<br/>
			</form>
		</div>
	</div>
</div>