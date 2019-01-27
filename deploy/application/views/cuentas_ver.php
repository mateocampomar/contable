	<div class="bdy-container">
		<?=$viewHeader?>
		<div class="ver-cuenta">
			<table border="0" cellpadding="0" cellspacing="1" class="tabla">
				<tr class="header">
					<td>Fecha</td>
					<?
					if ( $cuentaObj->show_txt_otros )
					{
						?><td><?=$cuentaObj->show_txt_otros?></td><?
					}
					?>
					<td>Movimiento</td>
					<td>Rubro</td>
					<td align="right">Crédito</td>
					<td align="right">Débito</td>
					<td align="right"><strong>Subtotal</strong></td>
				</tr>
				<?
					$trClass = "dark";
					
					foreach ( $movimientosArray as $movimientosObj )
					{		
						if ( $trClass == 'dark' )	$trClass = '';
						else						$trClass = 'dark';
						
						?>
						<tr class="<?=$trClass?>">
							<td><?=$movimientosObj->fecha?></td>
							<?
							if ( $cuentaObj->show_txt_otros )
							{
								?><td><?=$movimientosObj->txt_otros?></td><?
							}
							?>
							<td style="font-weight: bold;"><?=$movimientosObj->concepto?></td>
							<td>
								<?									
									if ( $movimientosObj->persona_id && $movimientosObj->rubro_id )
									{
										?>
										<span class="tag-rubro <?=$movimientosObj->color?>">
											<a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink">
												<img src="<? echo base_url( "assets/img/" . $movimientosObj->unique_name )?>.png" /> <?=$movimientosObj->nombre?>
											</a>
										</span>
										<?
									}
									else
									{
										?><a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink" style="color: red">?</a><?
									}
								?>
							</td>
							<td align="right" style="color: green;"><?=formatNumberCustom( $movimientosObj->credito )?></td>
							<td align="right" style="color: red;"><?=formatNumberCustom( $movimientosObj->debito )?></td>
							<td align="right"><strong><?=formatNumberCustom( $movimientosObj->saldo )?></strong></td>
						</tr>
						<?
					}
				?>
			</table>
		</div>
	</div>
</div>