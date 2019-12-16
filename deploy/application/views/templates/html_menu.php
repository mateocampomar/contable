			<header>
				<ul>
					<li><a href="<?=base_url('index.php/home/logout')?>" data-ajax="false">Logout</a></li>
				</ul>
			</header>
			<div id="left_header">
				<ol>
					<?
					//print_r($saldoSinRubrarArray);
						
					foreach( $menuCuentas as $key => $cuentasPorMoneda )
					{
						$saldo			= $cuentasPorMoneda['saldoTotal'];
						$cuentasList	= array();
						
						unset($cuentasPorMoneda['saldoTotal']);
						

						foreach ( $cuentasPorMoneda as $cuenta)
						{
							if ( $cuenta->saldo >= 0 )	$cssClass = 'positivo';
							else						$cssClass = 'negativo';
							
							$saldo_parts = explode( "," , number_format($cuenta->saldo, 2, "," , ".") );
							
							$cuentasList[]	= $cuenta->id;
							
							$sinRubrarAlert = ( $saldoSinRubrarArray[$cuenta->id]->total_credito || $saldoSinRubrarArray[$cuenta->id]->total_debito )	? true : false;
							
							?>
							<li class="<?=$cssClass?>" onclick="window.location.href='<?=base_url( 'index.php/cuentas/ver/' . $cuenta->id )?>'">
								<?
									if ( $sinRubrarAlert )
									{
										?><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>" class="icon"/><?
									}
								?>
								<h2><?=$cuenta->nombre?> <strong>(<?=$cuenta->moneda?>)</strong></h2>
								<div class="total">
									<small><?=$cuenta->simbolo?> </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small>
								</div>
							</li>
							<?
						}
						
						$saldo_parts = explode( "," , number_format($saldo, 2, "," , ".") );

						?>
						<li class="total-moneda" onclick="window.location.href='<?=base_url( 'index.php/cuentas/stats/' . implode( "-", $cuentasList ) )?>'">
							<div class="simbolo"><?=$key?>:</div>
							<div><small><?=$cuenta->simbolo?> </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small></div>
						</li>
						<?
					}
					?>
					<li class="total-moneda total-total" onclick="window.location.href='<?=base_url( 'index.php/cuentas/stats/' . implode( "-", $cuentasList ) )?>'">
						<div class="simbolo">TOTAL <small>USD</small></div>
						<div><small><?=$cuenta->simbolo?> </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small></div>
					</li>
				</ol>
			</div>