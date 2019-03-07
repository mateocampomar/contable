    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [<?
	          echo "'Fecha', 'Sin Rubro', 'Saldo'";

	          foreach ( $personasArray as $personaObj )
	          {
		          echo ", '" . $personaObj->nombre . "'";//, 'Matt', 'Comun'
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
			          
			          //print_r($movimiento);
		          }
		          
		          // Lista cada uno de los saldos.
		          foreach ( $personasArray as $personaObj )
		          {
				  		$toEcho .= ", " . round( $saldoPorPersonaArray[$personaObj->id], 2 );
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
			vAxis: {minValue: 0, textStyle: { fontSize:11 }},
			series: {
				0: { lineWidth: 1, lineDashStyle: [5, 5] },
				1: { lineWidth: 8, type:'area' },
			},
          legend: { position: 'none' },
          colors: ['red', '<?=( $saldoInicial >= 0 ) ? 'green' : '#C0392B'?>', <?
	          
	        foreach ( $personasArray as $personaObj )
		    {
	          echo "'" . $personaObj->color . "', ";
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

    </script>

	<div class="bdy-container">
		<?=$viewHeader?>
		<div class="ver-cuenta">
			<h2>Evolución del Saldo</h2>
			<div id="curve_chart" style="height: 700px"></div>
		</div>
		<div class="ver-cuenta">
			<h2>Gastos por Rubro</h2>
			<div id="chart_div" style="height: 700px"></div>
		</div>
	</div>
</div>