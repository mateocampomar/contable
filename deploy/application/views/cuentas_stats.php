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
			          if ( $movimiento->rubro_persona_id )
					  		$saldoPorPersonaArray[$movimiento->rubro_persona_id]	+= ($movimiento->credito - $movimiento->debito );
					  else
					  	$sinRubro	+= ($movimiento->credito - $movimiento->debito );

			          
			          $saldoInicial			+= ($movimiento->credito - $movimiento->debito );
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