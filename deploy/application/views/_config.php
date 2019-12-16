<div data-role="page" id="page1">
	<?=$viewLeft_menu?>
	<div class="bdy-container">
		<div class="ver-cuenta sinmenu">
			<form class="config">
				<h2>Configuraciones del Sisssstema</h2>
				<ul>
					<li><label>Mostrar cuentas auxiliares.&nbsp;&nbsp;&nbsp;<?=form_checkbox('newsletter', 'accept', TRUE, 'data-role="none"')?></label></li>
				</ul>
				<center style="width: 40%;"><?=form_submit('mysubmit', 'Submit Post!', ' data-theme="b"');?></center>
				<br/>
			</form>
		</div>
	</div>
</div>