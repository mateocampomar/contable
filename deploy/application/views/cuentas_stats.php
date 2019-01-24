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
	          foreach ( $saldosPorIntervalo as $movimientoObj )
	          {
		          $toEcho				= "";
		          $sumSaldoSinRubrar	= $movimientoObj->saldo;
		          $ultimoSaldo			= $movimientoObj->saldo;
		          
		          $movimientoArray = (array) $movimientoObj;
		          
		          //print_r($movimientoArray);

		          foreach ( $personasArray as $personaObj )
		          {
			          $toEcho .= ", " . $movimientoArray['saldo_cta' . $personaObj->id];
			          
			          $sumSaldoSinRubrar -= round( $movimientoArray['saldo_cta' . $personaObj->id], 2 );
		          }
		          
		          echo "['" . $movimientoObj->fecha . "', " . round( $sumSaldoSinRubrar, 2 ) . ", " . $movimientoObj->saldo . "" . $toEcho;

		          echo "],\n";
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
          colors: ['red', '<?=( $ultimoSaldo >= 0 ) ? 'green' : '#C0392B'?>', <?
	          
	        foreach ( $personasArray as $personaObj )
		    {
	          echo "'" . $personaObj->color . "', ";
	        }
	          
	      ?>]
        };

        var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        ['Rubro', '', { role: 'style' }],
        <?
	        $lastPersona	= false;
	        $primeraVez		= true;
	        
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

		        $barColor = ( $row->total >= 0 ) ? $row->color : $row->color_light;
		        
		        echo "['". $row->nombre."', " . $row->total . ", '" . $barColor . "'],\n";
		        

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