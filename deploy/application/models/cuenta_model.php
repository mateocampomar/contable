<?php
class cuenta_model extends MY_Model {
	
	public function listCuentas()
	{
		$this->db->select('*');
	
		$this->db->from('cuentas');
		
		$this->db->join('moneda', 'cuentas.moneda = moneda.moneda');
		
		$this->db->where('status = ' . 1);
		
		$this->db->order_by('cuentas.moneda', 'ASC');
		$this->db->order_by('nombre', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function getCuenta( $cuentaId )
	{
		$this->db->select('*');
	
		$this->db->from('cuentas');
		
		$this->db->join('moneda', 'cuentas.moneda = moneda.moneda');
		
		$this->db->where('status = ' . 1);
		$this->db->where('id = ' . $cuentaId );
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0];
	}

	public function ingresarMovimiento( $cuentaId, $fecha, $concepto, $credito, $debito, $saldo, $saldosPersonaArray=false, $txt_otros=false, $rubroId=false, $personaId=false )
	{
		$rubroModel		= new Rubro_model();
	
		$data = array(
			'cuentaId'		=> $cuentaId,
			'fecha'			=> $fecha,
			'concepto'		=> $concepto,
			'credito'		=> $credito,
			'debito'		=> $debito,
			'saldo'			=> $saldo,
			'status'		=> 1
		);
		
		if ( $txt_otros )
		{
			$data['txt_otros']	= $txt_otros;
		}
		
		if ( $rubroId )
		{
			$data['persona_id']	= $personaId;
			$data['rubro_id']	= $rubroId;
		}

		// Si no está el array con los sueldos entonces lo creo.
		if ( !is_array($saldosPersonaArray) )
		{
			$saldosPersonaArray = array();

			$personasArray	= $rubroModel->getPersona();

			foreach ( $personasArray as $personaObj )
			{
				$saldosPersonaArray[ $personaObj->id ] = $this->getSaldoPersona( $cuentaId, $personaObj->id );
			}
		}

 
		foreach ( $saldosPersonaArray as $saldosPersonaObj )
		{
			$saldosPersonaObj = (array) $saldosPersonaObj;

			$data[ 'saldo_cta' . $saldosPersonaObj['persona_id'] ] = $saldosPersonaObj['saldo'];
		}


		if ( $this->db->insert('movimientos_cuentas', $data) )
		{
			//echo $this->db->last_query() . ";\n";
			
			$insertId = $this->db->insert_id();
			
			if ( $this->actualizarSaldo( $cuentaId, $saldo ) )
			{	
				return $insertId;
			}
		}
		
		return false;
	}
	
	public function getUltimoMovimientoPorCuenta( $cuentaId )
	{
		$this->db->select('*');
	
		$this->db->from('movimientos_cuentas');
		
		$this->db->where('status = ' . 1);
		$this->db->where('cuentaId = ' . $cuentaId );
		
		$this->db->order_by('id', 'DESC');
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0];
	}
	
	public function setSessionFiltros()
	{
		//////////////
		// Personas //
		//////////////

		//$rubroModel		= new Rubro_model();
		//$personasArray	= $rubroModel->getPersona();
		
		//foreach( $personasArray as $personaObj )
		//{
		//	if ( $this->session->userdata( 'filter_' . $personaObj->unique_name ) )
		//	{
		//		$this->db->where('persona_id != ' . $personaObj->id );
		//	}
		//}

		////////////
		// Rubros //
		////////////

		$where = "";

		foreach ( $this->session->userdata( "filter_rubros" ) as $rubroId => $val )
		{
			if ( $val )
				$where .= '`rubro_id` = ' . $rubroId . " OR ";
		}

		//////////////
		// Personas //
		//////////////
		if ( $this->session->userdata( 'filter_sinrubrar' ) == false )		$where .= "`rubro_id` IS NULL";
		else																$where  = substr( $where, 0, -4 );



		$this->db->where("(" . $where . ")");

		return true;
	}
	
	public function getMovimientos( $cuentaId, $fecha=false, $filters=true )
	{
		if ( $filters )
		{
			$this->setSessionFiltros();
		}
		
		$this->db->select('*, movimientos_cuentas.id as movimientos_cuentas_id');
	
		$this->db->from('movimientos_cuentas');

		$this->db->join('rubro_persona', 'rubro_persona.id = movimientos_cuentas.persona_id', 'left');
		$this->db->join('rubro_cuenta', 'rubro_cuenta.id = movimientos_cuentas.rubro_id', 'left');
		
		if ( is_array($cuentaId) )
		{
			$where = "";

			foreach( $cuentaId as $cuentaIdParaWhere )
			{
				$where .= 'cuentaId = ' . $cuentaIdParaWhere . " OR ";
			}
			
			$where = substr( $where, 0, -4 );
			
			$this->db->where("(" . $where . ")");
		}
		else
		{
			$this->db->where('cuentaId = ' . $cuentaId );
		}

		$this->db->where('movimientos_cuentas.status = ' . 1);
		
		if ( $fecha )
		{
			$this->db->where("movimientos_cuentas.fecha = '" . $fecha . "'");
		}
		
		$this->db->order_by('movimientos_cuentas.id', 'ASC');

		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		return $query->result();
	}

	public function getMovimiento( $movimientoId )
	{
		$this->db->select('*, movimientos_cuentas.id as id');
	
		$this->db->from('movimientos_cuentas');
		
		$this->db->join('cuentas', 'cuentas.id = movimientos_cuentas.cuentaId');
		$this->db->join('moneda', 'moneda.moneda = cuentas.moneda');
		
		$this->db->where('movimientos_cuentas.id = ' . $movimientoId );
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0];
	}
	
	public function actualizarSaldo( $cuentaId, $saldo )
	{
		$data = array(
			'saldo'=> $saldo,
		);
		
		$this->db->where('id', $cuentaId);

		return $this->db->update('cuentas', $data);
	}


	public function getSaldoPersona( $cuentaId, $personaId )
	{
		$this->db->select('*');

		$this->db->from('cuentas_saldos_persona');

		$this->db->where('cuenta_id = ' . $cuentaId );
		$this->db->where('persona_id = ' . $personaId );

		$this->db->limit(1);

		$query = $this->db->get();

		$result = $query->result();
		
		// Ya existe el registro. Devuelvo el resultado.
		if ( count( $result ) )
		{
			return $result[0];
		}

		// No existe el registro. Lo creo.
		$data = array(
			'cuenta_id'		=> $cuentaId,
			'persona_id'	=> $personaId,
			'saldo'			=> 0,
		);
		
		if ( $this->db->insert('cuentas_saldos_persona', $data) )
		{
			return $this->getSaldoPersona( $cuentaId, $personaId );
		}
		
		// Error
		return false;
	}

	public function getSaldosByCuenta( $cuentaId, $fecha=false )
	{
		if ( !$fecha )
		{
			$this->db->select('*, cuentas_saldos_persona.id as id, cuentas_saldos_persona.saldo as saldo, rubro_persona.nombre as nombre');
	
			$this->db->from('cuentas_saldos_persona');
	
			$this->db->join('rubro_persona', 'rubro_persona.id = cuentas_saldos_persona.persona_id');
			$this->db->join('cuentas', 'cuentas.id = cuentas_saldos_persona.cuenta_id');
			$this->db->join('moneda', 'moneda.moneda = cuentas.moneda');
	
			$this->db->where('cuenta_id = ' . $cuentaId );
	
			$query = $this->db->get();
	
			return $query->result();
		}
		else
		{
			$this->db->select('*');
			
			$this->db->from('movimientos_cuentas');
			
			// Where
			$this->db->where('status = ' . 1);
			
			$this->db->where('cuentaId = ' . $cuentaId );
			$this->db->where("fecha >= '" . $fecha . "'" );
	
			$this->db->order_by('id', 'ASC');
			
			$this->db->limit(1);
	
			// Ejecutar Query
			$query = $this->db->get();
			
			//echo $this->db->last_query() . ";\n";
			
			$result = $query->result();
			
			if ( !isset($result[0]) )
				return false;
			
			$result = (array) $result[0];

			
			// Corrección de Saldo Persona
			if ( $result['persona_id'] )
			{
				$result['saldo_cta' . $result['persona_id'] ] = $result['saldo_cta' . $result['persona_id'] ] + $result['debito'] - $result['credito'];
			}
			
			// Corrección de Saldo.
			$result['saldo'] = $result['saldo'] + $result['debito'] - $result['credito'];
			
			return $result;
		}
	}


	public function setSaldoPersona( $id, $saldo )
	{
		// Update de movimiento_cuentas
		$data = array(
			'saldo'	=> $saldo,
		);

		$this->db->where('id', $id);

		$return = $this->db->update('cuentas_saldos_persona', $data);
		
		return $return;
	}
	
	public function nextMovimientoSinRubrar( $movimientoId, $cuentaId=false )
	{
		$this->db->select('*');
		
		$this->db->from('movimientos_cuentas');
		
		// Where
		$this->db->where('status = ' . 1);
		$this->db->where('persona_id', NULL);
		$this->db->where('rubro_id', NULL);
		
		if ( $cuentaId )
			$this->db->where('cuentaId = ' . $cuentaId );



		$this->db->order_by('id', 'ASC');
		
		$this->db->limit(1);

		// Ejecutar Query
		$query = $this->db->get();
		
		$result = $query->result();
		
		if ( count($result) )
		{
			return $result[0]->id;
		}
		
		return false;
	}
	
	public function getSaldosPorIntervalo( $cuentasArray )
	{
		$this->db->select('*, SUM(debito) as total_debito, SUM(credito) as total_credito');
	
		$this->db->from('movimientos_cuentas');
		
		$where = '(';
		foreach ( $cuentasArray as $cuenta )
		{
			$where .= "cuentaId = " . $cuenta . " OR ";
		}
		$where = substr($where, 0, -4);
		$where .= ')';


		$this->db->where($where, NULL, FALSE);
		$this->db->where('status = ' . 1);
		
		$this->db->group_by('DATE(fecha)');
		
		$this->db->order_by('fecha', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function pagarTarjeta( $cuentaId, $personaDebito=4 )
	{
		$rubroModel		= new rubro_model();
		$cuentaModel	= $this;

		$date = $this->getUltimoMovimientoPorCuenta( $cuentaId )->fecha;

		
		$cuentaObj		= $cuentaModel->getCuenta( $cuentaId );
		$cuentaDebito	= $cuentaObj->cta_debito;


		$cuentaDebitoObj	= $cuentaModel->getCuenta( $cuentaDebito );


		foreach( $rubroModel->getPersona() as $personaObj )
		{
			// Que no sea la misma persona que paga.
			if ( $personaDebito != $personaObj->id )
			{
				$saldoPersona		= $cuentaModel->getSaldoPersona( $cuentaId, $personaObj->id );
				$saldoPersonaDebito = $cuentaModel->getSaldoPersona( $cuentaId, $personaDebito );

				if ( $saldoPersona->saldo > 0  )
				{
					$creditoDebito	= 0;
					$debitoDebito	= $saldoPersona->saldo;
					$debitoCredito	= 0;
					$creditoCredito	= $saldoPersona->saldo;

					$saldo			= $cuentaObj->saldo - $saldoPersona->saldo;
					$saldoDebito	= $cuentaDebitoObj->saldo - $saldoPersona->saldo;
				}
				else
				{
					$creditoDebito	= 0;
					$debitoDebito	= -$saldoPersona->saldo;
					$debitoCredito	= 0;
					$creditoCredito	= -$saldoPersona->saldo;

					$saldo			= $cuentaObj->saldo + $saldoPersona->saldo;
					$saldoDebito	= $cuentaDebitoObj->saldo + $saldoPersona->saldo;
				}

				// Débito en la persona que envía
				$cuentaModel->ingresarMovimiento(
													$cuentaId,
													$date,
													'Pago de Tarjeta',
													$debitoCredito,
													$debitoDebito,
													$saldo,
													false,
													false,
													15,											// Tarjetas
													$personaDebito
											);

				$cuentaModel->setSaldoPersona( $saldoPersonaDebito->id, $saldoPersonaDebito->saldo + $debitoCredito - $debitoDebito );


				// Crédito en la persona que Recibe.
				$cuentaModel->ingresarMovimiento(
													$cuentaId,
													$date,
													'Pago de Tarjeta',
													$creditoCredito,
													$creditoDebito,
													$cuentaObj->saldo,
													false,
													false,
													$personaObj->rubro_tarjeta,
													$personaObj->id
											);

				$cuentaModel->setSaldoPersona( $saldoPersona->id, $saldoPersona->saldo + $creditoCredito - $creditoDebito );


				///////////////////////////////
				// CUENTA DEBITO / DE RETIRO //
				///////////////////////////////

				// Débito en la persona que envía
				$cuentaModel->ingresarMovimiento(
													$cuentaDebito,
													$date,
													'Pago de Tarjeta',
													$debitoCredito,
													$debitoDebito,
													$saldoDebito,
													false,
													false,
													$personaObj->rubro_tarjeta,
													$personaObj->id
											);

				$cuentaModel->setSaldoPersona(
												$cuentaModel->getSaldoPersona( $cuentaDebito, $personaObj->id )->id,
												$cuentaModel->getSaldoPersona( $cuentaDebito, $personaObj->id )->saldo + $debitoCredito - $debitoDebito
											);


				// Crédito en la persona que Recibe.
				$cuentaModel->ingresarMovimiento(
													$cuentaDebito,
													$date,
													'Pago de Tarjeta',
													$creditoCredito,
													$creditoDebito,
													$cuentaDebitoObj->saldo,
													false,
													false,
													15,											// Tarjetas
													$personaDebito
											);

				$cuentaModel->setSaldoPersona(
												$cuentaModel->getSaldoPersona( $cuentaDebito, $personaDebito )->id,
												$cuentaModel->getSaldoPersona( $cuentaDebito, $personaDebito )->saldo + $creditoCredito - $creditoDebito
											);
			}
		}

	}
}