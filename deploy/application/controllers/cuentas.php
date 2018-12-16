<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentas extends MY_Controller {

	public function ver( $cuentaId )
	{
		$this->data['cuentaId'] = $cuentaId;
		
		$this->load->view('templates/html_open',	$this->data);
		$this->load->view('cuentas_ver',			$this->data);
		$this->load->view('templates/html_close',	$this->data);
	}
	
	public function parser()
	{
		$json = array('ddd');
		
		print_r( $this->input->post() );
		
		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
}