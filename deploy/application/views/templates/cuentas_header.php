<ul class="saldos-menu">
<?
	foreach ( $personas as $persona )
	{
		if ( round( $persona['saldo'], 2 ) )
		{
			?>
			<li><img src="<? echo base_url( "assets/img/" . $persona['unique_name'] )?>.png" class="border" style="border-color: <?=$persona['color']?>" /><span><i><?=$monedaSimbolo?> </i><?=formatNumberCustom( $persona['saldo'] )?></span></li>
			<?
		}
	}

	if ( $saldoSinRubrar )
	{
		?>
		<li><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>"/><span><i><?=$monedaSimbolo?> </i><?=formatNumberCustom( $saldoSinRubrar )?></span></li>
		<?
	}


	if ( round( $checkSaldos, 2 ) )
	{
		?>
		<li><img src="<?=base_url( 'assets/img/icon_bug.png' )?>"/><span><i><?=$monedaSimbolo?> </i><?=formatNumberCustom( $checkSaldos )?></span></li>
		<?
	}
?>
</ul>




<ul class="cuenta-menu">
	<?
		if ( !$multicuenta )
		{
			?>
			<li>
				<div role="main" class="ui-content">
			    	<a href="#dialogPage" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_plus.png')?>" /></a>
				</div>
			</li>
			<?
		}
	?>
	<li>
		<div class="ui-content">
			<a href="<?=base_url('index.php/cuentas/stats/' . implode( "-", $cuentasArray ) )?>"><img src="<?=base_url('assets/img/icon_stats.png')?>" /></a>
		</div>
	</li>
	<?
		if ( !$multicuenta )
		{
			?>
			<li>
				<div class="ui-content">
					<a href="<?=base_url('index.php/cuentas/ver/' . implode( "-", $cuentasArray ) )?>"><img src="<?=base_url('assets/img/icon_list.png')?>" /></a>
				</div>
			</li>
			<?
		}
	?>
</ul>


<h1><?=implode(", ", $cuentas_nombres)?> <span style="font-weight: normal;">(<?=$moneda?>): <span style="font-size: 15pt;"><?=formatNumberCustom( $saldoTotal )?></span></span></h1>