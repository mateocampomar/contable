 <?
function color_luminance( $hex, $percent ) {
	
	// validate hex string
	
	$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
	$new_hex = '#';
	
	if ( strlen( $hex ) < 6 ) {
		$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
	}
	
	// convert to decimal and change luminosity
	for ($i = 0; $i < 3; $i++) {
		$dec = hexdec( substr( $hex, $i*2, 2 ) );
		$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
		$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
	}		
	
	return $new_hex;
}
?>

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
	          foreach ( $movimientosPorDia as $fecha => $diaArray )
	          {
		          $toEcho				= "";

				  // Suma los movimientos del día.
		          foreach ( $diaArray as $movimiento )
		          {
			          if ( $movimiento->persona_id )
					  		$saldoPorPersonaArray[$movimiento->persona_id]	+= ($movimiento->credito - $movimiento->debito );
					  else
					  	$sinRubro	+= ($movimiento->credito - $movimiento->debito );

			          
			          $saldoInicial			+= ($movimiento->credito - $movimiento->debito );
		          }
		          
		        // Lista cada uno de los saldos.
		        foreach ( $personasArray as $personaObj )
		        {
					if ( !$this->session->userdata( 'filter_' . $personaObj->unique_name ) )
					{
						$toEcho .= ", " . round( $saldoPorPersonaArray[$personaObj->id], 2 );
					}
		        }

		          
		        echo "['" . $fecha . "', " . round( $sinRubro, 2 ) . ", " . round( $saldoInicial, 2 ) . $toEcho . "],\n";
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
          colors: ['red', '<?=( $saldoInicial >= 0 ) ? 'green' : '#C0392B'?>', <?
	          
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
		        	echo "['". $row->nombre."', " . $row->total . ", '" . $barColor . "'],\n";
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