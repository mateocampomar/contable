<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubro extends MY_Controller {

	public function ver( $rubros )
	{
		$rubrosArray	= $rubros;
		//$rubrosArray 	= explode("-", $rubros);

		//if ( count($rubrosArray) == 1 )		$rub;
		//}



		/*/
		 * Para Rubros por Mes
		/*/
		$rubrosPorMesArray = array();
		
		//$rubroModel->cuentasArray = $cuentasArray;
		
		for ($mes=1; $mes<=12; $mes++ )
		{
			$fecha					= date('Y') . '-' . sprintf('%02d', $mes);
			$rubrosEntreFechasArray	= array();
			
			foreach ( $rubroModel->getTotalesEntreFechas( $fecha . "-01", $fecha . "-31" ) as $rubrosEntreFechasObj )
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

		$this->data['rubrosPorMesArray']		= $rubrosPorMesArray;
		$this->data['todosLosRubros']			= $todosLosRubros;


		print_r( $this->data );






		
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('rubro_ver',					$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}
}