<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentas extends MY_Controller {

	public function ver( $cuentas )
	{
		$cuentasArray 	= explode("-", $cuentas);
		// No es multicuenta	
		$cuentaId = $cuentas;

		// Para el menu
		$this->renderMenu( $cuentasArray );
		// Fin Menu

		$cuentaModel	= new Cuenta_model();
		//$rubroModel		= new Rubro_model();
		
		
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
	
	public function stats( $cuentas )
	{
		$cuentasArray 	= explode("-", $cuentas);

		// Para el menu
		$this->renderMenu( $cuentasArray );

		// Models
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();


		/*/
		 * Para Evolución de Saldo
		/*/
		$personasObj = $rubroModel->getPersona();

		$saldosInicialPorPersonaArray	= array();
		$saldoInicial					= 0;
		$sinRubro						= 0;

		// Todo esto tiene que salir de config.
		$date			= '2019-01-01';
		//$end_date		= '2019-03-07';
		$end_date 		= date('Y-m-d', time()); // [TODO] Esto tiene que ser el ultimo movimiento que tenga la cuenta.

		// [TODO] Esto tiene que ser una función.
		foreach ( $cuentasArray as $cuentaId )
		{
			$saldos		= $cuentaModel->getSaldosByCuenta( $cuentaId, $date );
			
			$saldoInicial += $saldos['saldo'];
			
			$sinRubro = $saldos['saldo'];


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
				
				$sinRubro -= $saldos['saldo_cta' . $persona->id ];
			} 
		}

		
		$saldosPorDia	= array();
		
		// Para cada uno de los días del intervalo.
		while ( strtotime( $date ) <= strtotime( $end_date ) )
		{
			$movimientos = $cuentaModel->getMovimientos( $cuentasArray, $date, false );
			
			$movimientosPorDia[$date] = $movimientos;
			
			//print_r($movimientos);

			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}


		$this->data['personasArray']			= $personasObj;
		$this->data['saldoPorPersonaArray']		= $saldosInicialPorPersonaArray;
		$this->data['saldoInicial']				= $saldoInicial;
		$this->data['sinRubro']					= $sinRubro;
		$this->data['movimientosPorDia']		= $movimientosPorDia;
		
		/** Fin Evolución de Saldo **/
		
		
		/*/
		 * Para Totales por Rubro.
		/*/
		
		
		$totalesPorRubro		= $rubroModel->getTotalesPorRubro( $cuentasArray );

		$this->data['totalesPorRubro']		= $totalesPorRubro;
		
		//print_r($this->data['totalesPorRubro']);
		//echo "-----------------------";
		//die;
		
		/** Fin Totales por Rubro **/
		
		
		
		/*/
		 * Para Rubros por Mes
		/*/
		$rubrosPorMesArray = array();
		
		$rubroModel->cuentasArray = $cuentasArray;
		
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
		
		/** Fin Rubros por Mes **/
		
		

		// Views
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('cuentas_stats',				$this->data);
		$this->load->view('templates/cuentas_popups',	$this->headerData);
		$this->load->view('templates/html_close',		$this->data);
	}

	private function renderMenu( $cuentasArray )
	{
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		
		$this->headerData['cuentasArray']		= $cuentasArray;
		
		$this->headerData['cuentas_nombres']	= array();
		$this->headerData['moneda']				= null;
		$this->headerData['saldoTotal']			= 0;
		$this->headerData['personas']			= array();
		$this->headerData['personasArray']		= $rubroModel->getPersona();
		$this->headerData['saldoSinRubrar']		= 0;
		
		$this->headerData['multicuenta']		= ( count( $cuentasArray ) > 1 ) ? true : false;
		
		$this->headerData['checkSaldos']		= 0;

		$this->headerData['txt_otros']			= array();

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
																				"color"			=> $persona->color,
																				"nombre"		=> $persona->nombre
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

		$rubroArrayGrouped = $rubroModel->getRubrosGrouped();
		$this->headerData['rubroArrayGrouped']		= $rubroArrayGrouped;


		$this->data['viewHeader'] = $this->load->view('templates/cuentas_header',	$this->headerData, true);
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
						$rubrado = $rubroModel->setRubrado( $movimiento, $rubroArray['persona_id'], $rubroArray['rubro_id'], ( isset( $rubroArray['concepto'] ) ) ? $rubroArray['concepto'] : false );
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
	
	public function transferir_persona()
	{
		$json = array(
					'error'		=> false,
					'action'	=> false
				);

		$cuentaId			= $this->input->post('cuentaId');
		$de_persona			= $this->input->post('de_persona');
		$de_personaRubro	= $this->input->post('de_persona_rubro');
		$para_persona		= $this->input->post('para_persona');
		$para_personaRubro	= $this->input->post('para_persona_rubro');
		$montoNbr			= $this->input->post('montoNbr');
		$conceptoTxt		= $this->input->post('conceptoTxt');
		
		//echo $de_persona . " <--> " . $montoNbr . " <--> " . $conceptoTxt;
		
		// Ingresar Movimiento.
		$saldosPersonaArray = array();

		$cuentaModel= new Cuenta_model();
		$rubroModel = new Rubro_Model();
				
		$personasArray = $rubroModel->getPersona();


		// Listo todas las cuentas y pongo los saldos en cero.
		foreach ( $personasArray as $personaObj )
		{
			$saldosPersonaArray[ $personaObj->id ] = (array) $cuentaModel->getSaldoPersona( $cuentaId, $personaObj->id );
		}
		
		$cuentaObj = $cuentaModel->getCuenta( $cuentaId );
		
		if ( !$conceptoTxt )
		{
			$personaDeObj	= $rubroModel->getUnaPersona( $de_persona );
			$personaParaObj = $rubroModel->getUnaPersona( $para_persona );

			$conceptoTxt = "Transferencia de '" . $personaDeObj->nombre . "' a '" . $personaParaObj->nombre . "'.";
		}
		
		//echo $de_persona;
		
		//print_r($saldosPersonaArray);


		// Movimiento DE
		//$saldosPersonaArray[$de_persona]['saldo'] = $saldosPersonaArray[$de_persona]['saldo'] - $montoNbr;
		
		//print_r($saldosPersonaArray);

		$movimiento_de = $cuentaModel->ingresarMovimiento( $cuentaId, date('Y-m-d', time()), $conceptoTxt, 0, $montoNbr, ( $cuentaObj->saldo - $montoNbr ), $saldosPersonaArray);
		
		if ( $movimiento_de )
		{
			// Rubrado DE
			if ( $rubroModel->setRubrado( $movimiento_de, $de_persona, $de_personaRubro, $conceptoTxt ) )
			{
				// Movimiento PARA
				$saldosPersonaArray[$de_persona]['saldo'] = $saldosPersonaArray[$de_persona]['saldo'] - $montoNbr;
				
				//print_r($saldosPersonaArray);
				//die;

				$movimiento_para = $cuentaModel->ingresarMovimiento( $cuentaId, date('Y-m-d', time()), $conceptoTxt, $montoNbr, 0, $cuentaObj->saldo, $saldosPersonaArray);
				
				if ( $movimiento_para )
				{
					// Rubrado PARA
					if ( $rubroModel->setRubrado( $movimiento_para, $para_persona, $para_personaRubro, $conceptoTxt ) )
					{
						$json['error']		= false;
					}
					else
					{
						$json['error']		= true;
						$json['errorTxt']	= 'Error: No se pudo rubrar el movimiento PARA:.';
					}
				}
				else
				{
					$json['error']		= true;
					$json['errorTxt']	= 'Error: No se pudo ingresar el movimiento PARA:.';
				}
			}
			else
			{
				$json['error']		= true;
				$json['errorTxt']	= 'Error: No se pudo rubrar el movimiento DE:.';
			}
		}
		else
		{
			$json['error']		= true;
			$json['errorTxt']	= 'Error: No se pudo ingresar el movimiento DE:.';
		}

		$this->data['json'] = $json;
		
		$this->load->view('_json',	$this->data);
	}
}