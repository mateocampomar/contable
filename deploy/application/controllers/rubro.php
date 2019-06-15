<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubro extends MY_Controller {

	public function ver( $rubros )
	{
		$rubrosArray	= $rubros;
		
		$rubroModel		= new Rubro_model();
		$cuentaModel	= new Cuenta_model();


		/*/
		 * Para Rubros por Mes
		/*/
		$rubrosPorMesArray = array();
		
		//$rubroModel->cuentasArray = $cuentasArray;
		
		for ($mes=1; $mes<=12; $mes++ )
		{
			$fecha					= date('Y') . '-' . sprintf('%02d', $mes);
			$rubrosEntreFechasArray	= array();
			
			foreach ( $rubroModel->getTotalesEntreFechas( $fecha . "-01", $fecha . "-31", $rubrosArray ) as $rubrosEntreFechasObj )
			{
				$rubrosEntreFechasArray[$rubrosEntreFechasObj->rubro_id] = $rubrosEntreFechasObj;
			}
			
			$rubrosPorMesArray[$fecha] = $rubrosEntreFechasArray;
		}
		
		
		$todosLosRubros = array();
		
		foreach ( $rubrosPorMesArray as $mesRubros )
		{
			foreach( $mesRubros as $rubrosObj )
			{				
				$todosLosRubros[$rubrosObj->rubro_id] = $rubrosObj;
			}
		}
		
		$this->data['rubroObj']				= $rubroModel->getRubro( $rubrosArray );
		
		//print_r($this->data['rubroObj']);

		$this->data['rubrosPorMesArray']	= $rubrosPorMesArray;
		$this->data['todosLosRubros']		= $todosLosRubros;


		$movimientosByRubroArray	= $cuentaModel->getMovimientosByRubro( $rubrosArray );
		$this->data['movimientosArray']	= $movimientosByRubroArray;
		
		//print_r($movimientosByRubroArray);
		
		
		$cakeChartArray = array(
					'negativo'	=> 0,
					'positivo'	=> 0
		);
		foreach ($movimientosByRubroArray as $movimientoObj) {
			$cakeChartArray['positivo'] += $movimientoObj->credito;
			$cakeChartArray['negativo'] += $movimientoObj->debito;
		}
		
		$this->data['pieChartArray']	= $cakeChartArray;
		


		
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('rubro_ver',					$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}
}