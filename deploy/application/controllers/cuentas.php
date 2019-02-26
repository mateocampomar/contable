<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentas extends MY_Controller {

	public function ver( $cuentas )
	{
		// Para el menu
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		
		$cuentasArray 	= explode("-", $cuentas);
		
		$this->headerData['cuentasArray']		= $cuentasArray;
		
		$this->headerData['cuentas_nombres']	= array();
		$this->headerData['moneda']				= null;
		$this->headerData['saldoTotal']			= 1;
		$this->headerData['personas']			= array();
		$this->headerData['saldoSinRubrar']		= 0;
		
		$this->headerData['multicuenta']		= ( count( $cuentasArray ) > 1 ) ? true : false;
		
		$this->headerData['checkSaldos']		= 0;
		
		$this->headerData['txt_otros']			= array();

		foreach ( $cuentasArray as $cuentaId )
		{
			$cuentaObj				= $cuentaModel->getCuenta( $cuentaId );
			$saldosPersonaObj		= $cuentaModel->getSaldosByCuenta( $cuentaId );
			
			$this->headerData['cuentas_nombres'][$cuentaId]	= $cuentaObj->nombre;
			
			$this->headerData['moneda']			= $cuentaObj->moneda;
			$this->headerData['monedaSimbolo']	= $cuentaObj->simbolo;
			
			$this->headerData['saldoTotal']	+= $cuentaObj->saldo;
			
			$this->headerData['checkSaldos']+= $cuentaObj->saldo;
			
			foreach ( $saldosPersonaObj as $persona )
			{
				if ( !isset( $this->headerData['personas'][$persona->persona_id] ) )
				{
					$this->headerData['personas'][$persona->persona_id]	= array(
																				"persona_id"	=> $persona->persona_id,
																				"saldo"			=> $persona->saldo,
																				"unique_name"	=> $persona->unique_name,
																				"color"			=> $persona->color
																			);
				}
				else
				{
					$this->headerData['personas'][$persona->persona_id]['saldo']	+= $persona->saldo;
				}
				
				$this->headerData['checkSaldos']	-= $persona->saldo;
			}
			
			$saldoSinRubrar			= $rubroModel->getTotalSinRubrar( $cuentaId );
			$this->headerData['saldoSinRubrar']		+= $saldoSinRubrar->total;

			$this->headerData['checkSaldos']	-= $saldoSinRubrar->total;
			
			if ( $cuentaObj->show_txt_otros )
				$this->headerData['txt_otros'][]	= $cuentaObj->show_txt_otros;
		}


		$this->data['viewHeader'] = $this->load->view('templates/cuentas_header',	$this->headerData, true);
		// Fin Menu
		
		
		$movimientosArray	= $cuentaModel->getMovimientos( $cuentaId );
		$this->data['movimientosArray']	= $movimientosArray;
		
		
		$this->data['headerData']	= $this->headerData;
		
		$this->data['multicuenta'] = $this->headerData['multicuenta'];
		
		if ( !$this->data['multicuenta'] )
		{
			$cuentaObj				= $cuentaModel->getCuenta( $cuentasArray[0] );
			$this->data['cuentaObj']	= $cuentaObj;
		}

		
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('cuentas_ver',				$this->data);
		if ( !$this->data['multicuenta'] )
			$this->load->view('templates/cuentas_popups',	$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}

	public function check( $cuentaId )
	{
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		
		$cuentaObj			= $cuentaModel->getCuenta( $cuentaId );
		$movimientosArray	= $cuentaModel->getMovimientos( $cuentaId );


		print_r($movimientosArray);


		
	}
	
	public function stats( $cuentas )
	{
		// Para el menu
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		
		$cuentasArray 	= explode("-", $cuentas);
		
		$this->headerData['cuentasArray']		= $cuentasArray;
		
		$this->headerData['cuentas_nombres']	= array();
		$this->headerData['moneda']				= null;
		$this->headerData['saldoTotal']			= 1;
		$this->headerData['personas']			= array();
		$this->headerData['saldoSinRubrar']		= 0;
		
		$this->headerData['multicuenta']		= ( count( $cuentasArray ) > 1 ) ? true : false;
		
		$this->headerData['checkSaldos']		= 0;

		foreach ( $cuentasArray as $cuentaId )
		{
			$cuentaObj				= $cuentaModel->getCuenta( $cuentaId );
			$saldosPersonaObj		= $cuentaModel->getSaldosByCuenta( $cuentaId );
			
			//print_r($saldosPersonaObj);
			
			$this->headerData['cuentas_nombres'][$cuentaId]	= $cuentaObj->nombre;
			
			$this->headerData['moneda']			= $cuentaObj->moneda;
			$this->headerData['monedaSimbolo']	= $cuentaObj->simbolo;
			
			$this->headerData['saldoTotal']	+= $cuentaObj->saldo;
			
			$this->headerData['checkSaldos']+= $cuentaObj->saldo;
			
			foreach ( $saldosPersonaObj as $persona )
			{
				if ( !isset( $this->headerData['personas'][$persona->persona_id] ) )
				{
					$this->headerData['personas'][$persona->persona_id]	= array(
																				"persona_id"	=> $persona->persona_id,
																				"saldo"			=> $persona->saldo,
																				"unique_name"	=> $persona->unique_name,
																				"color"			=> $persona->color
																			);
				}
				else
				{
					$this->headerData['personas'][$persona->persona_id]['saldo']	+= $persona->saldo;
				}
				
				$this->headerData['checkSaldos']	-= $persona->saldo;
			}
			
			$saldoSinRubrar			= $rubroModel->getTotalSinRubrar( $cuentaId );
			$this->headerData['saldoSinRubrar']		+= $saldoSinRubrar->total;

			$this->headerData['checkSaldos']	-= $saldoSinRubrar->total;
		}


		$this->data['viewHeader'] = $this->load->view('templates/cuentas_header',	$this->headerData, true);
		// Fin Menu
		
		$rubroModel		= new Rubro_model();
		
		$personasObj = $rubroModel->getPersona();
		
		$saldosInicialPorPersonaArray	= array();
		$saldoInicial					= 0;
		$sinRubro						= 0;

		$date			= '2019-01-01';
		//$end_date		= '2019-02-28';
		$end_date 		= date('Y-m-d', time());
		
		// [TODO] Esto tiene que ser una función.
		foreach ( $cuentasArray as $cuentaId )
		{
			$saldos		= $cuentaModel->getSaldosByCuenta( $cuentaId, $date );
			
			$saldoInicial += $saldos['saldo'];
			
			//print_r($saldos);

			foreach ($personasObj as $persona )
			{
				if ( !isset( $saldosInicialPorPersonaArray[$persona->id] ) )
				{
					$saldosInicialPorPersonaArray[$persona->id]	= $saldos['saldo_cta' . $persona->id ];
				}
				else
				{
					$saldosInicialPorPersonaArray[$persona->id] += $saldos['saldo_cta' . $persona->id ];
				}
			} 
		}
		
		//$movimientos = $cuentaModel->getMovimientos( $cuentasArray );
		
		//print_r($movimientos);
		
		$saldosPorDia	= array();
		
		// Para cada uno de los días del intervalo.
		while (strtotime($date) <= strtotime($end_date))
		{
			$movimientos = $cuentaModel->getMovimientos( $cuentasArray, $date );
			
			$movimientosPorDia[$date] = $movimientos;

			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}

		
		$personasArray			= $rubroModel->getPersona();


		$this->data['personasArray']			= $personasArray;
		$this->data['saldoPorPersonaArray']		= $saldosInicialPorPersonaArray;
		$this->data['saldoInicial']				= $saldoInicial;
		$this->data['sinRubro']					= $sinRubro;
		$this->data['movimientosPorDia']		= $movimientosPorDia;


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

			    case 'acsa-web':
			    
			    	$parserResult = $parserModel->acsaWeb( $cuentaId, $inputTxt );
			    	
			    	break;

			    case 'visa-itau':
			    
			    	$parserResult = $parserModel->visaIatu( $cuentaId, $inputTxt );
			    	
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

				
				foreach ( $parserResult as $rowArray )
				{
					// Cuenta Id
					$cuentaId = ( isset( $rowArray['cuenta_id'] ) ) ? $rowArray['cuenta_id'] : $cuentaId;

					// Listo todas las cuentas y pongo los saldos en cero.
					foreach ( $personasArray as $personaObj )
					{
						$saldosPersonaArray[ $personaObj->id ] = $cuentaModel->getSaldoPersona( $cuentaId, $personaObj->id );
					}
					

					$saldo = $rowArray['saldo'];
					if ( $saldo === null )
					{
						$cuentaObj = $cuentaModel->getCuenta( $cuentaId );
						
						$saldo = $cuentaObj->saldo + $rowArray['credito'] - $rowArray['debito'];
					}
					
					if ( !isset($rowArray['txt_otros']) )
					{
						$rowArray['txt_otros'] = NULL;
					}


					// Ingresar Movimiento.
					$movimiento = $cuentaModel->ingresarMovimiento( $cuentaId, $rowArray['fecha'], $rowArray['concepto'], $rowArray['credito'], $rowArray['debito'], $saldo, $saldosPersonaArray, $rowArray['txt_otros']);
	
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
		$concepto		= $this->input->post('concepto');
		
		$rubroModel	= new Rubro_Model();
		$cuentaModel= new Cuenta_model();
		
		$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );
		
		if ( $rubroModel->setRubrado( $movimientoId, $personaId, $rubroId, $concepto ) )
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