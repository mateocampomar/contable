<ul class="saldos-menu">
<?
	foreach ( $personas as $persona )
	{
		if ( round( $persona['saldo'], 2 ) )
		{
			$saldo_parts = explode( "," , formatNumberCustom( $persona['saldo'] ) );
			
			?>
			<li><img src="<? echo base_url( "assets/img/" . $persona['unique_name'] )?>.png" class="border" style="border-color: <?=$persona['color']?>" /><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
			<?
		}
	}

	if ( $saldoSinRubrar )
	{
		$saldo_parts = explode( "," , formatNumberCustom( $saldoSinRubrar ) );
		
		?>
		<li><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>" class="border" style="border-color:#e10000;" /><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
		<?
	}


	if ( round( $checkSaldos, 2 ) )
	{
		$saldo_parts = explode( "," , formatNumberCustom( $checkSaldos ) );
		
		?>
		<li><img src="<?=base_url( 'assets/img/icon_bug.png' )?>"/><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
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
				<div class="ui-content">
					<a href="#dialogPageTransfer" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_transfer.png')?>" /></a>
				</div>
			</li>
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
<?
	$saldo_parts = explode( "," , formatNumberCustom( $saldoTotal ) );
?>
<h1>
	<div class="saldo"><span><?=$monedaSimbolo?></span> <?=( isset($saldo_parts[0]) && $saldo_parts[0] ) ? $saldo_parts[0] : '0'?><span>,<?=(isset($saldo_parts[1])) ? $saldo_parts[1] : '00'?></span></div>
	<div><?=implode(", ", $cuentas_nombres)?> <span style="font-weight: normal;">[<?=$moneda?>]</span></div>
</h1>