<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubro extends MY_Controller {

	public function ver( $rubros, $monedaReturn=null )
	{
		$total_total_pos = 0;
		$total_total_neg = 0;
			
		if(preg_match("/[a-z]/i", $rubros))
		{
			preg_match('#\[(.*?)\]#', $rubros, $match);
			$rubros = $match[1];
		}
		
		$rubrosArray	= $rubros;
		
		$rubroModel		= new Rubro_model();
		$cuentaModel	= new Cuenta_model( $monedaReturn );

		// Para el menu
		$this->data['viewLeft_menu'] = $this->load->view('templates/html_menu',		$this->data, true);
		// Fin Menu


		/*/
		 * Para Rubros por Mes
		/*/
		$rubrosPorMesArray = array();
		
		for ($mes=1; $mes<=12; $mes++ )
		{
			$fecha					= _CONFIG_YEAR . '-' . sprintf('%02d', $mes);
			$rubrosEntreFechasArray	= array();

			$rubrosEntreFechas = $rubroModel->getTotalesPorRubroMoneda( null, $monedaReturn, $fecha . "-01", $fecha . "-31", $rubrosArray );
			
			//echo $fecha . "\n\n\n";
			//print_r($rubroModel->stats);

			foreach ( $rubrosEntreFechas as $rubrosEntreFechasObj )
			{
				$rubrosEntreFechasObj = (object) $rubrosEntreFechasObj;

				$rubrosEntreFechasArray[$rubrosEntreFechasObj->persona_id][$rubrosEntreFechasObj->rubro_id] = $rubrosEntreFechasObj;
			}

			$rubrosPorMesArray[$fecha] = $rubrosEntreFechasArray;
			
			//print_r($rubroModel->stats);
			
			$total_total_pos += $rubroModel->stats['total_total_pos'];
			$total_total_neg += $rubroModel->stats['total_total_neg'];
		}
		
		///die;


		// Saco cuales van a ser los rubros que se usen en el view.
		$todosLosRubros = array();
		
		foreach ( $rubrosPorMesArray as $mesRubros )
		{
			foreach ( $mesRubros as $personaRubros )
			{
				foreach( $personaRubros as $rubrosObj )
				{				
					$todosLosRubros[$rubrosObj->rubro_id] = $rubrosObj;
				}
			}
		}


		$this->data['rubroObj']				= $rubroModel->getRubro( $rubrosArray );
		$this->data['rubrosPorMesArray']	= $rubrosPorMesArray;
		$this->data['todosLosRubros']		= $todosLosRubros;
		
		//print_r($rubrosPorMesArray);
		//die;



		/** Busco los movimientos **/
		$movimientosByRubroArray	= $cuentaModel->getMovimientos( false, false, 'rubro_id:' . $rubrosArray,  $monedaReturn);


		$this->data['movimientosArray']	= $movimientosByRubroArray;
		
		//print_r($movimientosByRubroArray);
		

		/** Para el gráfico de torta con **/
		$pieChartArray = array(
					'negativo'	=> round(-$total_total_neg),
					'positivo'	=> round($total_total_pos)
		);
		//foreach ($movimientosByRubroArray as $movimientoObj) {
		//	$pieChartArray['positivo'] += $movimientoObj->credito;
		//	$pieChartArray['negativo'] += $movimientoObj->debito;
		//}
		
		$this->data['pieChartArray']	= $pieChartArray;


		/** View **/
		$this->data['monedaReturn']		= $monedaReturn;
		
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('rubro_ver',					$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}
}