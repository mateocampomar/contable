<div data-role="page" id="page1">
	<?=$viewLeft_menu?>
	<div class="bdy-container">
		<?=$viewHeader?>
		<br/><br/><br/><br/><br/><br/><br/>
		<?
		if ( count($cuentasArray) == 1 && isset($cuentaObj->moneda_original) )
		{
			?>
			<div class="red-alert">
				<span><strong>ATENCION:</strong> La cuenta es en <strong><?=$cuentaObj->moneda_original?></strong> (<?=formatNumberCustom($cuentaObj->saldo_original)?>) y está siendo mostrada en <strong><?=$cuentaObj->moneda?><strong>.</span>
			</div>
			<br/>
			<?
		}
		?>
		<div class="ver-cuenta">
			<table border="0" cellpadding="0" cellspacing="1" class="tabla">
				<tr class="header">
					<td align="center">Fecha</td>
					<?
						if ( $multicuenta )
						{
							?><td><strong>Cuenta</strong></td><?
						}
					?>
					<?
					if ( count( $headerData['txt_otros'] ) )
					{
						?><td><?=implode(",", $headerData['txt_otros']) ?></td><?
					}
					?>
					<td>Concepto</td>
					<td>Rubro</td>
					<td align="right">Crédito</td>
					<td align="right">Débito</td>
					<?
						if ( !$multicuenta )
						{
							?><td align="right"><strong>Subtotal</strong></td><?
								
							if ( isset( $cuentaObj->moneda_original ) )
							{
								?>
								<td align="right" style="background-color: white"></td>
								<td align="right" class="td-destacado">En <?=$monedaReturn?></td>
								<td align="right" class="td-destacado">Saldo <?=$monedaReturn?></td>
								<?
							}
						}
					?>
				</tr>
				<?
					$trClass = "dark";
					
					foreach ( $movimientosArray as $movimientosObj )
					{
						//print_r($movimientosObj);
						//die;
						
						// No muestro las líneas que están relacionadas a un pago de tarjeta y son de la persona LABURO.
						if ( $movimientosObj->mov_relacionado && $movimientosObj->persona_id == 4 )	continue;
						
						
						if ( !$movimientosObj->mov_relacionado )
						{
							if ( $trClass == 'dark' )	$trClass = '';
							else						$trClass = 'dark';
						}


						?>
						<tr class="<?=$trClass?>">
							<td align="center">
								<?
									if (!$movimientosObj->mov_relacionado)		echo fecha_format_SqltoPrint( $movimientosObj->fecha );
								?>
							</td>
							<?
							if ( $multicuenta )
							{								
								?><td><a href="<?=base_url( 'index.php/cuentas/ver/' . $movimientosObj->cuentaId )?>"><?=$movimientosObj->cuenta_nombre?></a></strong></td><?
							}
							?>
							<?
							if ( count( $headerData['txt_otros'] ) )
							{
								?><td><?=$movimientosObj->txt_otros?></td><?
							}
							?>
							<td style="font-weight: bold;">
								<?
								if (!$movimientosObj->mov_relacionado)			echo $movimientosObj->concepto;
								?>
							</td>
							<td>
								<?									
									if ( $movimientosObj->persona_id && $movimientosObj->rubro_id )
									{						
										?>
										<span class="tag-rubro <?=$movimientosObj->persona_color?>" title="<?=$movimientosObj->persona_nombre?> > <?=$movimientosObj->rubro_nombre?>">
											<a href="#" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" data-rubroid="<?=$movimientosObj->rubro_id?>" class="rubradoLink">
												<img src="<? echo base_url( "assets/img/" . $movimientosObj->persona_unique_name )?>.png" /> <?=(!$movimientosObj->mov_relacionado) ? $movimientosObj->rubro_nombre : ''?>
											</a>
										</span>
										<a href="#dialogPageRubrado" id="movlink_<?=$movimientosObj->movimientos_cuentas_id?>" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" data-rubroid="<?=$movimientosObj->rubro_id?>"></a>
										<?
									}
									else
									{
										?>
										<span>
											<a href="#" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink" style="color:red;">?</a>
										</span>
										<a href="#dialogPageRubrado" id="movlink_<?=$movimientosObj->movimientos_cuentas_id?>" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>"></a><?
									}
								?>
							</td>
							<td align="right" style="color: <?=(!$movimientosObj->mov_relacionado) ? 'green'	: 'grey; font-style: italic'?>;"><?=formatNumberCustom( $movimientosObj->credito )?></td>
							<td align="right" style="color: <?=(!$movimientosObj->mov_relacionado) ? 'red'		: 'grey; font-style: italic'?>;"><?=formatNumberCustom( -$movimientosObj->debito )?></td>
							<?
								if ( !$multicuenta )	// Si es una cuenta sola y no varias combianadas.
								{
									if ( !$movimientosObj->mov_relacionado )
									{
										?><td align="right"><strong><?=formatNumberCustom( $movimientosObj->saldo, 2, true )?></strong></td><?
									}
									else
									{
										echo "<td></td>";
									}
										
									if ( isset( $cuentaObj->moneda_original ) )
									{
										$diferenciaCreditoDebito = $movimientosObj->tp_credito - $movimientosObj->tp_debito;
										
										?>
										<td align="center" style="background-color: white"><?='<small class="tipo_cambio">' . formatNumberCustom($movimientosObj->tipo_cambio, 1) . '</small>'?></td>
										<td align="right" class="td-destacado" style="color: <?=( $diferenciaCreditoDebito >= 0 ) ? "green" : "red"?>"><?=formatNumberCustom( $diferenciaCreditoDebito )?></td>
										<td align="right" class="td-destacado"><strong><?=formatNumberCustom($movimientosObj->tp_saldo)?></strong></td>
										<?
									}
								}
							?>
						</tr>
						<?
					}
				?>
			</table>
		</div>
	</div>
</div>