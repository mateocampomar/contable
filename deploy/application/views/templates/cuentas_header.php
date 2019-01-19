		<ul class="saldos-menu">
		<?
			$totalSaldosPersona = 0;
			
			foreach ( $saldosArray as $saldoObj )
			{
				if ( round($saldoObj->saldo,2) )
				{
					$totalSaldosPersona += $saldoObj->saldo;
					
					?>
					<li><img src="<? echo base_url( "assets/img/" . $saldoObj->unique_name )?>.png" class="border" style="border-color: <?=$saldoObj->color?>" /><span><i><?=$saldoObj->simbolo?> </i><?=formatNumberCustom( $saldoObj->saldo )?></span></li>
					<?
				}
			}

			if ( $saldoSinRubrar->total )
			{
				?>
				<li><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>"/><span><i><?=$cuentaObj->simbolo?> </i><?=formatNumberCustom( $saldoSinRubrar->total )?></span></li>
				<?
			}
			
			$bugSaldo = round( $totalSaldosPersona + $saldoSinRubrar->total - $cuentaObj->saldo, 2 );

			if ( $bugSaldo )
			{
				?>
				<li><img src="<?=base_url( 'assets/img/icon_bug.png' )?>"/><span><i><?=$cuentaObj->simbolo?> </i><?=formatNumberCustom( $bugSaldo )?></span></li>
				<?
			}
		?>
		</ul>
		<ul class="cuenta-menu">
			<li>
				<div role="main" class="ui-content">
			    	<a href="#dialogPage" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_plus.png')?>" /></a>
				</div>
			</li>
			<li>
				<div class="ui-content">
					<a href="<?=base_url('index.php/cuentas/stats/' . $cuentaObj->id )?>"><img src="<?=base_url('assets/img/icon_stats.png')?>" /></a>
				</div>
			</li>
			<li>
				<div class="ui-content">
					<a href="<?=base_url('index.php/cuentas/ver/' . $cuentaObj->id )?>"><img src="<?=base_url('assets/img/icon_list.png')?>" /></a>
				</div>
			</li>
		</ul>
		<h1><?=$cuentaObj->nombre?> <span style="font-weight: normal;">(<?=$cuentaObj->moneda?>): <span style="font-size: 15pt;"><?=formatNumberCustom( $cuentaObj->saldo )?></span></span></h1>