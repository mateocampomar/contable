<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtros extends MY_Controller {

	public function setPersona( $personaName )
	{
		$personaName = "filter_" . $personaName;

		
		if ( $this->session->userdata( $personaName ) === false )
		{
			$this->session->set_userdata($personaName, true);
		}
		else
		{
			$this->session->set_userdata($personaName, false);
		}

		$json['refresh'] = true;


		$this->data['json'] = $json;

		$this->load->view('_json',	$this->data);
	}
	
	public function setRubros()
	{
		$rubrosActivo = $this->input->post('rubrosActivo');
		
		$sessionArray = array();
		
		foreach ( json_decode( $rubrosActivo ) as $value )
		{
			$sessionArray[$value] = true;
		}

		$this->session->set_userdata( "filter_rubros", $sessionArray);

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