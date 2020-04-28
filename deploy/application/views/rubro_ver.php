	<script type="text/javascript">
	   google.charts.load('current', {'packages':['bar']});
	   google.charts.setOnLoadCallback(drawChart2);
	
	    function drawChart2() {
	        var data = google.visualization.arrayToDataTable([
		        <?
					echo "['Mes'";
					
					foreach ($todosLosRubros as $rubro )
					{
						echo ", '" . $rubro->nombre ." (+)'";
						echo ", '" . $rubro->nombre ." (-)'";
					}
					echo "],\n";
					
					//print_r($rubrosPorMesArray);
					
					foreach ($rubrosPorMesArray as $mes => $personasArray )
					{
						//print_r($personasArray);
						
						echo "[";
						echo "'" . $mes . "'";

						$totalCredito_rubro = 0;
						$totalDebito_rubro	= 0;

						foreach ( $personasArray as $rubroArray )
						{
							foreach ($rubroArray as $rubro )
							{
								$totalCredito_rubro += $rubro->total_credito;
								$totalDebito_rubro	+= $rubro->total_debito;
							}

						}

						foreach ( $todosLosRubros as $rubroId => $rubro )
						{
							echo "," . $totalCredito_rubro;
							echo "," . $totalDebito_rubro;
						}
	
						echo "],\n";
					}
				?>
	        ]);
	
	        var options2 = {
				chartArea:{
					left:100,
					top:100,
					width:'50%',
					height:'75%'
				},
				isStacked: true,
				legend: {
					position: 'none'
				},
				series: {
					<?
						$count = 0;
						$colorArray = array();
	
	
		      			foreach ($todosLosRubros as $rubro )
						{
							echo $count . ": { color: '#99cc99' },\n";
							
							$count++;
							
							echo $count . ": { color: '#ff6666' },\n";
							
							$count++;
						}
					?>
				},
	        };

	        var chart = new google.charts.Bar(document.getElementById('rubro_por_mes'));
	
	        chart.draw(data, google.charts.Bar.convertOptions(options2));
	        
	        
	        
	        //
	        // Pie Chart
	        //
	        
	        google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);
			
			      function drawChart() {
			
			        var data = google.visualization.arrayToDataTable([
			          ['Task', 'Hours per Day'],
				        <?
					        foreach( $pieChartArray as $key => $result )
					        {
						        echo "['" . $key . "', " . $result . "],\n";
					        }
						?>
			        ]);
			
			        var options = {
						legend: { position: 'none' },
						chartArea:{left:30,top:20,width:'80%',height:'80%'},
			            slices: {
			              0: { color: '#ff6666' },
			              1: { color: '#99cc99' }
			            }
			        };
			
			        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			
			        chart.draw(data, options);
			      }
	    	}

	</script>
<div data-role="page" id="page1">
	<?=$viewLeft_menu?>
	<div class="bdy-container">
		<div class="fixed-menu">
			<h1>
				<div class="saldo">[Algún Dato del Rubro]</div>
				<div><?=$rubroObj->nombre?></div>
			</h1>
		</div>
		<div class="ver-cuenta top" style="float: right;">
			<div id="piechart" style="height: 310px; width: 280px;"></div>
		</div>
		<div class="ver-cuenta top" style="height: 310px; margin-right: 300px;">
			<div id="rubro_por_mes" style="height: 300px; margin: 10px;"></div>
		</div>
		<div class="ver-cuenta">
			<table border="0" cellpadding="0" cellspacing="1" class="tabla">
				<tr class="header">
					<td align="center">Fecha</td>
					<td><strong>Cuenta</strong></td>
					<td>Concepto</td>
					<td>Persona</td>
					<td>Moneda Original</td>
					<td align="right">Movimiento<br/><small style="font-weight: normal;">moneda original</small></td>
					<td align="right">Acumulado<br/><small style="font-weight: normal;">moneda original</small></td>
					<td style="background-color: white;" width="1"></td>
					<td class="td-destacado" align="right">En <?=$monedaReturn?></td>
					<td class="td-destacado" align="right" >Acumulado <?=$monedaReturn?></td>
				</tr>
				<?
					$trClass = "dark";
					
					$acumulado		= 0;
					$acumuladoTC	= 0;
					
					foreach ( $movimientosArray as $movimientosObj )
					{	
						//print_r($movimientosObj);
							
						if ( $trClass == 'dark' )	$trClass = '';
						else						$trClass = 'dark';
						
						$diferenciaCreditoDebito  = $movimientosObj->credito - $movimientosObj->debito;
						$diferenciaTC			  = $movimientosObj->tp_credito - $movimientosObj->tp_debito;
						$acumulado				 += $diferenciaCreditoDebito;
						$acumuladoTC			 += $diferenciaTC;
						
						?>
						<tr class="<?=$trClass?>">
							<td align="center"><?=$movimientosObj->fecha?></td>
							<td><strong><a href="<?=base_url( 'index.php/cuentas/ver/' . $movimientosObj->cuentaId )?>/<?=$monedaReturn?>"><?=$movimientosObj->cuenta_nombre?></a></strong></td>
							<td style="font-weight: bold;"><?=$movimientosObj->concepto?></td>
							<td>
								<?									
									if ( $movimientosObj->persona_id && $movimientosObj->rubro_id )
									{										
										?>
										<span class="tag-rubro <?=$movimientosObj->persona_color?>">
											<a href="#dialogPageRubrado" data-rel="dialog" data-rel="back" data-transition="pop" data-movimientoid="<?=$movimientosObj->movimientos_cuentas_id?>" class="rubradoLink">
												<img src="<? echo base_url( "assets/img/" . $movimientosObj->persona_unique_name )?>.png" /> <?=$movimientosObj->persona_nombre?>
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
							<td align="center"><strong><?=$movimientosObj->moneda?></strong></td>
							<td align="right" style="color: <?=( $diferenciaCreditoDebito >= 0 ) ? "green" : "red"?>"><?=formatNumberCustom( $diferenciaCreditoDebito )?></td>
							<td align="right" style="color: <?=( $acumulado >= 0 ) ? "green" : "red"?>"><?=formatNumberCustom( $acumulado )?></td>
							<td align="center" style="background-color: white;"><?
								
								if ( $movimientosObj->moneda <> $monedaReturn )
								{
									?><small class="tipo_cambio"><?=$movimientosObj->tipo_cambio?></small><?
								}
								
							?></td>
							<td align="right" class="td-destacado" style="color: <?=( $diferenciaTC >= 0 ) ? "green" : "red"?>"><strong><?=formatNumberCustom( $diferenciaTC )?></strong></td>
							<td align="right" class="td-destacado" style="color: <?=( $acumuladoTC >= 0 ) ? "green" : "red"?>"><strong><?=formatNumberCustom( $acumuladoTC )?></strong></td>
						</tr>
						<?
					}
				?>
			</table>
		</div>
	</div>
</div>