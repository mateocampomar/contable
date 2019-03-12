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
}