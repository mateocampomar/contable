<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
          [<?
	        echo "'Fecha', 'Sin Rubro', 'Saldo'";

			foreach ( $personasArray as $personaObj )
			{
				if ( !$this->session->userdata( 'filter_' . $personaObj->unique_name ) )
				{
					echo ", '" . $personaObj->nombre . "'";   
				}
			}
	          
	          ?>],
          <?
	        
	        // Cargo los saldos iniciales desde el controlador.  
	        $saldoChart		= $saldo_inicial;
			$sinRubroChart	= $saldo_sinRubro;
			
			//print_r($sinRubroChart);
			

//foreach( $saldoInicial as $moneda => $saldo )
//{
  //if ( $moneda == $monedaReturn )	$saldo_Inicial += $saldo;
  //else								$saldo_Inicial += $saldo / $cotizacionInicial->$monedaReturn;

//}
  
//  print_r($movimientosPorDia);

	$saldoPorPersonaArray = $saldo_inicialPorPersonaArray;
  
  // Recorro día a día
  foreach ( $movimientosPorDia as $fecha => $diaArray )
  {       
      $toEcho				= "";

	  // Recorro y sumo los movimientos del día.
      foreach ( $diaArray['movimientos'] as $movimiento )
      {
          $saldoDelMovimiento = ($movimiento->credito - $movimiento->debito );
  
    
          // Cambio de moneda si se pide en otra.
          // El saldo se convierte a la moneda de monedaReturn;
          //if ( $monedaReturn !=  $movimiento->moneda )
          //{
	      //    $saldoDelMovimiento = $saldoDelMovimiento / $diaArray['cotizacion']->$monedaReturn;
	          
	          //if ( !isset($saldoPorPersonaArray[$movimiento->persona_id][$monedaReturn]) )	$saldoPorPersonaArray[$movimiento->persona_id][$monedaReturn] = 0;
	          
	          //$saldo_personasModendaReturn[$movimiento->persona_id] =	$saldoPorPersonaArray[$movimiento->persona_id][$monedaReturn]
	          //													+ ( $saldoPorPersonaArray[$movimiento->persona_id][$movimiento->moneda] / $diaArray['cotizacion']->$monedaReturn );
          //}
          
         // print_r( $saldoPorPersonaArray);
          
          // Adjudico el saldo a una persona o a Sin Rubro.
          if ( $movimiento->persona_id )	$saldoPorPersonaArray[$movimiento->persona_id][$movimiento->moneda]	+= $saldoDelMovimiento;
		  else								$sinRubroChart[$movimiento->moneda]									+= $saldoDelMovimiento;

          // Sumo todo para tener el saldo inicial.
          $saldoChart[$movimiento->moneda]																		+= $saldoDelMovimiento;
      }

      
      $saldoTotal_monedaReturn		= 0;
	  $sinRubroTotal_mondeaReturn	= 0;
      
      foreach( $saldoChart as $moneda => $saldo )
      {
	      //echo $diaArray['cotizacion']->$moneda;
	      //echo $moneda . "==" . $monedaReturn;

	      if ( $moneda == $monedaReturn )
	      {
		      $saldoTotal_monedaReturn		+= $saldo;
		      $sinRubroTotal_mondeaReturn	+= $sinRubroChart[$moneda];
		  }
	      else
	      {
		      $saldoTotal_monedaReturn		+= $saldo / $diaArray['cotizacion']->$monedaReturn;
		      $sinRubroTotal_mondeaReturn	+= $sinRubroChart[$moneda] / $diaArray['cotizacion']->$monedaReturn;
		  }
	      
	      //echo "\n" . $saldo . " saldo: " . $saldoTotalEnMonedaReturn . "\n";
      }

      
      //-----------------------------------------
      //print_r($diaArray['cotizacion']);
      
      //$saldoColumnChart	= 0;
      
		//foreach ($diaArray['cotizacion'] as $moneda => $cotizacion)
		//{
		//	if ( $moneda == 'id' || $moneda == 'timestamp' || $moneda == 'fecha' )	continue;
		//
		//	if ( $moneda != $monedaReturn )	$saldoColumnChart		+= $saldoChart[$moneda] / $diaArray['cotizacion']->$monedaReturn;
		//	else								$saldoColumnChart	+= $saldoChart[$moneda];
		//}
      
      //print_r($saldo_personasModendaReturn);
      

    
    //print_r($saldoPorPersonaArray);
    
    foreach ( $personasArray as $personaObj )
    {
		if ( !$this->session->userdata( 'filter_' . $personaObj->unique_name ) )
		{
			// Lista cada uno de los saldos.
			$saldoTotalPersona_monedaReturn = 0;
			//if ( !isset($saldo_personasModendaReturn[$personaObj->id]) )	$saldo_personasModendaReturn[$personaObj->id] = array();
			
			//print_r($saldoPorPersonaArray[$personaObj->id]);
			
			if ( isset($saldoPorPersonaArray[$personaObj->id]) )
			{				
				foreach( $saldoPorPersonaArray[$personaObj->id] as $moneda => $saldo )
				{
				      if	( $moneda == $monedaReturn )	$saldoTotalPersona_monedaReturn	+= $saldo;
				      else									$saldoTotalPersona_monedaReturn	+= $saldo / $diaArray['cotizacion']->$monedaReturn;
				}
			}
			
			$toEcho .= ", " . round( $saldoTotalPersona_monedaReturn, 2 );
		}
    }
        
    //print_r($saldoTotalPersona_monedaReturn);

      
    echo "['" . $fecha . "', " . round( $sinRubroTotal_mondeaReturn, 2 ) . ", " . round( $saldoTotal_monedaReturn, 2 ) . $toEcho . "],\n";

  }
	       ?>
        ]);

        var options = {
			isStacked: false,
			lineWidth: 2,
			curveType: 'none',
			chartArea: {
				height: '100%',
				width: '100%',
				top: 25,
				left: 75,
				bottom: 50,
				right: 20
			},
			slantedText: true,
			hAxis: {
				textStyle: {
					fontSize:9,
					color: '#999'
				}
			},
			vAxis: {minValue: 0, textStyle: { fontSize:11 }, viewWindowMode:'maximized' },
			series: {
				0: { lineWidth: 1, lineDashStyle: [5, 5] },
				1: { lineWidth: 8, type:'area' },
			},
          legend: { position: 'none' },
          colors: ['red', '<?=( $saldoTotal_monedaReturn >= 0 ) ? 'green' : '#C0392B'?>', <?
	          
	        foreach ( $personasArray as $personaObj )
		    {
			    if ( !$this->session->userdata( 'filter_' . $personaObj->unique_name ) )
				{
	        		echo "'" . $personaObj->color_light . "', ";
	        	}
	        }
	          
	      ?>]
        };

        var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }

	  // Por Rubro
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);

	function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        ['Rubro', '', { role: 'style' }],
        <?
	        $lastPersona	= false;
	        $primeraVez		= true;
	        
	        //print_r($totalesPorRubro);
	        
	        foreach( $totalesPorRubro as $row )
	        {	        
		        if ( $lastPersona != $row->persona_id )
		        {
			        if ( !$primeraVez )
			        {
				        echo "['', 0, ''],\n";
			        }
		  
			  		echo "['-------> ". strtoupper( $row->persona_nombre ) . "', 0, ''],\n";
			        
			        $lastPersona	= $row->persona_id;
			        $primeraVez		= false;
		        }

		        $barColor = ( $row->total >= 0 ) ? $row->color_dark : $row->color_light;
		        
		        if ( $row->nombre )
		        {
		        	echo "['". $row->nombre." [" . $row->rubro_id . "]', " . $row->total . ", '" . $barColor . "'],\n";
		        }
		        else
		        {
			        echo "['Sin Rubro', " . $row->total . ", '#cc0000'],\n";
			        echo "['', 0, ''],\n";
		        }
		        

		    }
		?>
      ]);

      var options = {
		chartArea: {
			height: '100%',
			width: '100%',
			top: 25,
			left: 150,
			right: 50,
			bottom: 50,
		},
		hAxis: {
			textStyle: {
				fontSize:11,
				color: '#000'
			}
		},
        vAxis: {
			textStyle: {
				fontSize:11,
			}
        },
        legend: { position: 'none' }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      
        //var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

		// The select handler. Call the chart's getSelection() method
		function selectHandler() {
			var selectedItem = chart.getSelection()[0];
			if (selectedItem) {
				var value = data.getValue(selectedItem.row, 0);
				
				window.location.replace("<?=base_url('index.php/rubro/ver')?>/" + value );
			}
		}
		
		// Listen for the 'select' event, and call my function selectHandler() when
		// the user selects something on the chart.
		google.visualization.events.addListener(chart, 'select', selectHandler);
    }
    
    <?
	   // print_r($rubrosPorMesArray);
	    
    ?>

    
    
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
	        <?
				echo "['Mes'";
				
				foreach ($todosLosRubros as $rubro )
				{
					echo ", '" . $rubro->nombre ."'";
				}
				echo "],\n";

				
				foreach ($rubrosPorMesArray as $mes => $rubrosArray )
				{
									//print_r($rubrosArray);
					
					echo "[";
					echo "'" . $mes . "'";
					
					foreach ( $todosLosRubros as $rubroId => $rubro )
					{
						//print_r($rubro);
						
						if ( isset($rubrosArray[$rubro->persona_id][$rubroId]->total) ) 
						{											echo "," . $rubrosArray[$rubro->persona_id][$rubroId]->total;	}
						else
						{											echo ",0";									}
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
						$color = $rubro->color_dark;

						// Sin Rubrar
						if ( !$color )	$color	= '#cc0000';
						
						//if ( !isset( $colorArray[$color] ) )
						//{
						//	$colorArray[$color] = color_luminance( $color, 0 );
						//}
						//else
						//{
						//	$colorArray[$color] = color_luminance( $colorArray[$color], 0.1 );
						//}
						
						echo $count . ": { color: '" . $color . "' },\n";
						
						$count++;
					}
				?>
			},
        };

        var chart = new google.charts.Bar(document.getElementById('rubro_por_mes'));

        chart.draw(data, google.charts.Bar.convertOptions(options2));
        
      }
      			


    </script>
   
<div data-role="page" id="page1">
	<?=$viewLeft_menu?>
	<div class="bdy-container">
		<?=$viewHeader?>
		<div class="ver-cuenta top">
			<h2>Evolución del Saldo</h2>
			<div id="curve_chart" style="height: 350px"></div>
		</div>
		<div class="ver-cuenta">
			<h2>Gastos por Rubro</h2>
			<div id="chart_div" style="height: 700px"></div>
		</div>
		<div class="ver-cuenta">
			<h2>Rubros por mes</h2>
			<div id="rubro_por_mes" style="height: 625px; margin: 50px;"></div>
		</div>
	</div>
</div>