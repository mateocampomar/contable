<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentas extends MY_Controller {

	public function ver( $cuentaId )
	{
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		
		$cuentaObj			= $cuentaModel->getCuenta( $cuentaId );
		$movimientosArray	= $cuentaModel->getMovimientos( $cuentaId );
		$saldosArray		= $cuentaModel->getSaldosByCuenta( $cuentaId );
		
		$saldoSinRubrar = $rubroModel->getTotalSinRubrar( $cuentaId );

		
		$this->data['cuentaObj']		= $cuentaObj;
		$this->data['movimientosArray']	= $movimientosArray;
		$this->data['saldosArray']		= $saldosArray;
		$this->data['saldoSinRubrar']	= $saldoSinRubrar;
		
		$this->data['viewHeader'] = $this->load->view('templates/cuentas_header',	$this->data, true);
		
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('cuentas_ver',				$this->data);
		$this->load->view('templates/cuentas_popups',	$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}
	
	public function stats( $cuentaId )
	{
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();

		// Para el menu
		$cuentaObj				= $cuentaModel->getCuenta( $cuentaId );
		$movimientosArray		= $cuentaModel->getMovimientos( $cuentaId );
		$saldosArray			= $cuentaModel->getSaldosByCuenta( $cuentaId );
		$saldoSinRubrar			= $rubroModel->getTotalSinRubrar( $cuentaId );

		$this->data['cuentaObj']		= $cuentaObj;
		$this->data['movimientosArray']	= $movimientosArray;
		$this->data['saldosArray']		= $saldosArray;
		$this->data['saldoSinRubrar']	= $saldoSinRubrar;

		$this->data['viewHeader'] = $this->load->view('templates/cuentas_header',	$this->data, true);
		// Fin Menu


		$saldosPorIntervalo		= $cuentaModel->getSaldosPorIntervalo( $cuentaId );
		$personasArray			= $rubroModel->getPersona();
		
		$totalesPorRubro		= $rubroModel->getTotalesPorRubro( $cuentaId );

		
		$this->data['saldosPorIntervalo']	= $saldosPorIntervalo;
		$this->data['personasArray']		= $personasArray;
		$this->data['totalesPorRubro']		= $totalesPorRubro;


		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('cuentas_stats',				$this->data);
		$this->load->view('templates/cuentas_popups',	$this->data);
		$this->load->view('templates/html_close',		$this->data);
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
		
		// Valudación
		if ( !$inputTxt )
		{
			$json['error']		= true;
			$json['errorTxt']	= 'No hay texto que ingresar.';
		}
		else
		{
			// Models
			$cuentaModel	= new Cuenta_model();
			$cuentaObj = $cuentaModel->getCuenta( $cuentaId );
	
			$parserModel	= new Parser_model();
			
	
			switch ( $cuentaObj->parser )
			{
			    case 'itau-web':
			    
			    	$parserResult = $parserModel->itauWeb( $cuentaId, $inputTxt );
			    	
			    	break;
	
				default:
					$json['error']		= true;
					$json['errorTxt']	= 'No se encontró el parser.';
			}

			// Ingresar Movimientos Array		
			if ( is_array( $parserResult ) && !isset( $parserResult['error'] ) )
			{
				$saldosPersonaArray = array();
				
				$rubroModel = new Rubro_Model();
				
				$personasArray = $rubroModel->getPersona();
				
				// Listo todas las cuentas y pongo los saldos en cero.
				foreach ( $personasArray as $personaObj )
				{
					$saldosPersonaArray[ $personaObj->id ] = $cuentaModel->getSaldoPersona( $cuentaId, $personaObj->id );
				}
				
				foreach ( $parserResult as $rowArray )
				{
					// Ingresar Movimiento.
					$movimiento = $cuentaModel->ingresarMovimiento( $cuentaId, $rowArray['fecha'], $rowArray['concepto'], $rowArray['credito'], $rowArray['debito'], $rowArray['saldo'], $saldosPersonaArray);
	
					if ( !$movimiento )
					{
						$json['error']		= true;
						$json['errorTxt']	= "No se pudo ingresar el movimiento en la db.";

						break;
					}
					
					// Rubrado Automático
					$rubroModel		= new Rubro_model();
					
					$rubroArray = $rubroModel->rubradoAutomatico( $rowArray['concepto'] );
					
					if ( $rubroArray )
					{
						$rubrado = $rubroModel->setRubrado( $movimiento, $rubroArray['persona_id'], $rubroArray['rubro_id'] );
					}

				}

				$json['okTxt']		= 'Nuevos movimientos ingresados ok';
				$json['action']		= 'reload';

			}
			else
			{
				$json['error']		= true;
				$json['errorTxt']	= $parserResult['error'];
			}
		}


		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);

	}
	
	public function rubrar( $movimientoId )
	{
		$json = array(
					'error'		=> false,
					'html'		=> false
				);

		//$movimientoId = $this->input->post('movimientoId');

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
	
	public function setRubro()
	{
		$json = array(
					'error'		=> false,
					'action'	=> false
				);
	
		$movimientoId	= $this->input->post('movimientoId');
		$personaId		= $this->input->post('personaId');
		$rubroId		= $this->input->post('rubroId');
		
		$rubroModel	= new Rubro_Model();
		$cuentaModel= new Cuenta_model();
		
		$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );
		
		if ( $rubroModel->setRubrado( $movimientoId, $personaId, $rubroId ) )
		{
			$json['error']		= false;
			$json['nextId']		= $cuentaModel->nextMovimientoSinRubrar( $movimientoId, $movimientoObj->cuentaId );
		}
		else
		{
			$json['error']		= true;
			$json['errorTxt']	= 'Error';
		}
		
		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
}