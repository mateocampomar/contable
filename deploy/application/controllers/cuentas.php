<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentas extends MY_Controller {

	public function ver( $cuentaId )
	{
		$cuentaModel	= new Cuenta_model();
		
		$cuentaObj			= $cuentaModel->getCuenta( $cuentaId );
		$movimientosArray	= $cuentaModel->getMovimientos( $cuentaId );
		
		$this->data['cuentaObj']		= $cuentaObj;
		$this->data['movimientosArray']	= $movimientosArray;
		
		$this->load->view('templates/html_open',	$this->data);
		$this->load->view('cuentas_ver',			$this->data);
		$this->load->view('templates/html_close',	$this->data);
	}
	
	public function parser()
	{
		$json = array(
					'error'		=> false,
					'action'	=> false
				);

		// Post
		$cuentaId = $this->input->post('cuentaId');
		$inputTxt = $this->input->post('inputTxt');

		// Models
		$cuentaModel	= new Cuenta_model();
		$cuentaObj = $cuentaModel->getCuenta( $cuentaId );

		$parserModel	= new Parser_model();
		

		switch ( $cuentaObj->parser )
		{
		    case 'itau-web':

				if ( $parserModel->itauWeb( $cuentaId, $inputTxt ) )
				{
					$json['okTxt']		= 'Nuevos movimientos ingresados ok';
					$json['action']		= 'reload';
				}
				else
				{
					$json['error']		= true;
					$json['errorTxt']	= 'Ups! No se pudo parsear el texto ingresado.';
				}

				break;

			default:
				$json['error']		= true;
				$json['errorTxt']	= 'No se encontró el parser.';
		}
		
		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
	
	public function rubrar()
	{
		$json = array(
					'error'		=> false,
					'html'		=> false
				);

		$movimientoId = $this->input->post('movimientoId');

		// Models
		$rubroModel	= new rubro_model();
		$cuentaModel	= new Cuenta_model();
		$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );
		
		$rubroArray = array();
		
		foreach ( $rubroModel->getPersona() as $personaKey => $personasObj )
		{
			$rubroArray[$personaKey]['object']	= $personasObj;
			$rubroArray[$personaKey]['cuentas'] = $rubroModel->getCuentas( $personasObj->id );
		}
		
		$this->data['movimientoObj']	= $movimientoObj;
		$this->data['rubroArray']		= $rubroArray;

		$html = $this->load->view('_rubrar', $this->data, true);
		$json['html']	= $html;
		
		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
}