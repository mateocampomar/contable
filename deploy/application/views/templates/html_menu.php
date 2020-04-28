			<header>
				<ul>
					<li><a href="<?=base_url('index.php/home/logout')?>" data-ajax="false">Logout</a></li>
					<li> | </li>
					<li><a href="<?=base_url('index.php/config')?>" data-ajax="false">Config</a></li>
					<li> | </li>
					<li>
						<form method="post" action="/index.php/config/set_config_year">
							<input type="hidden" name="redirectUrl" value="<?=current_url()?>" />
							<select name="config_year" id="config_year" data-role="none" onchange="this.form.submit()">
							        <option value="2019"<?=(_CONFIG_YEAR == 2019) ? ' selected="selected"' : ''?>>2019</option>
							        <option value="2020"<?=(_CONFIG_YEAR == 2020) ? ' selected="selected"' : ''?>>2020</option>
							</select>
						</form>
					</li>
				</ul>
			</header>
			<div id="left_header">
				<ol>
					<?
					//print_r($saldoSinRubrarArray);
					$cuentasListAll	= array();
						
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
							
							$cuentasList[]		= $cuenta->id;
							$cuentasListAll[]	= $cuenta->id;
							
							$sinRubrarAlert = ( $saldoSinRubrarArray[$cuenta->id]->total_credito || $saldoSinRubrarArray[$cuenta->id]->total_debito )	? true : false;
							
							?>
							<li class="<?=$cssClass?>" onclick="window.location.href='<?=base_url( 'index.php/cuentas/ver/' . $cuenta->id . '/' . $cuenta->moneda )?>'">
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
						<li class="total-moneda" onclick="window.location.href='<?=base_url( 'index.php/cuentas/stats/' . implode( "-", $cuentasList ) . '/' . $cuenta->moneda )?>'">
							<div class="simbolo"><?=$key?>:</div>
							<div><small><?=$cuenta->simbolo?> </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small></div>
						</li>
						<?
					}
					
					$saldo_parts = explode( "," , formatNumberCustom( $saldoTotalDolares ) );
					
					?>
					<li class="total-moneda total-total" onclick="window.location.href='<?=base_url( 'index.php/cuentas/stats/' . implode( "-", $cuentasListAll ) .'/USD' )?>'">
						<div class="simbolo">TOTAL <small>USD</small></div>
						<div><small>u$s </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small></div>
					</li>
				</ol>
			</div>