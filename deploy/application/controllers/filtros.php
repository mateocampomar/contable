<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtros extends MY_Controller {

	public function setPersona( $personaName )
	{
		$rubroModel		= new rubro_model();
		$filtrosModel	= new filtros_model();
		
		$personaObj = $rubroModel->getUnaPersona( false, $personaName );
		
		$personaName	= "filter_" . $personaName;

		
		if ( $this->session->userdata( $personaName ) === false )
		{
			$this->session->set_userdata($personaName, true);

			if ( $personaObj )	$filtrosModel->setAllRubros( false, $personaObj );
		}
		else
		{
			$this->session->set_userdata($personaName, false);

			if ( $personaObj )	$filtrosModel->setAllRubros( true, $personaObj );
		}
		
		//echo $personaName;
		//print_r($this->session->userdata( $personaName ));

		$json['refresh'] = true;

		$this->data['json'] = $json;

		$this->load->view('_json',	$this->data);
	}
	
	public function setRubros()
	{
		$rubroModel = new rubro_model();
		$filtrosModel = new filtros_model();

		$rubrosActivo = $this->input->post('rubrosActivo');

		// Seteo de Rubros en session
		$filtrosModel->setAllRubros( false );
		
		$sessionArray = $this->session->userdata( "filter_rubros" );
		
		foreach ( json_decode( $rubrosActivo ) as $value )
		{
			$sessionArray[$value] = true;
		}
		
		//print_r($sessionArray);

		$this->session->set_userdata( "filter_rubros", $sessionArray);
		
		
		// Me fijo si hay personas con los rubros completos o vacíos.
		foreach( $rubroModel->getRubrosGrouped() as $personaId => $rubroArray )
		{
			$trueValue		= 0;
			$falseValue		= 0;
			$sessionInput	= false;
			
			foreach ( $rubroArray as $rubroId => $rubroObj )
			{
				if ( isset($sessionArray[$rubroId]) && $sessionArray[$rubroId] )		$trueValue++;
				else																	$falseValue++;
			}
			
			if ( $falseValue == 0 )			$sessionInput	= false;
			elseif ( $trueValue	== 0 )		$sessionInput	= true;
			else							$sessionInput	= 'some';
			
			//echo $trueValue . " - " . $falseValue . " -> " . $sessionInput . "\n";
			
			$personaObj = $rubroModel->getUnaPersona( $personaId );
			
			$this->session->set_userdata("filter_" . $personaObj->unique_name, $sessionInput);
		}		

		$json['refresh'] = true;

		$this->data['json'] = $json;

		$this->load->view('_json',	$this->data);
	}
	
	public function selectRubros( $persona )
	{
		$json = array(
					'error'		=> false,
					'html'		=> false
				);

		// Models
		$rubroModel	= new rubro_model();
		
		$this->data['persona']		= $persona;
		
		$rubroArray = array();
		
		foreach ( $rubroModel->getPersona() as $personaKey => $personasObj )
		{
			$rubroArray[$personaKey]['object']	= $personasObj;
			$rubroArray[$personaKey]['cuentas'] = $rubroModel->getCuentas( $personasObj->id );
		}
		
		$this->data['rubroArray']			= $rubroArray;
		$this->data['sessionRubrosArray']	= $this->session->userdata( "filter_rubros" );

		$html = $this->load->view('filtros_rubros', $this->data, true);
		$json['html']	= $html;
		
		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
}