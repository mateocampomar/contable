<?php
class rubro_model extends MY_Model {
	
	public function getCuentas( $cuentaId=false )
	{
		$this->db->select('*, rubro_cuenta.nombre as nombre, rubro_cuenta.id as rubro_id');
	
		$this->db->from('rubro_cuenta');
		
		$this->db->join('rubro_persona', 'rubro_cuenta.rubro_persona_id = rubro_persona.id');
		
		// If
		$this->db->where('rubro_cuenta.status = ' . 1);

		if ( $cuentaId )
			$this->db->where('rubro_persona_id = ' . $cuentaId);

		// Order
		$this->db->order_by('rubro_cuenta.nombre', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}

	public function getPersona()
	{
		$this->db->select('*');
	
		$this->db->from('rubro_persona');
		
		$this->db->where('status = ' . 1);
		
		$this->db->order_by('nombre', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function setRubrado( $movimientoId, $personaId, $rubroId )
	{

		$cuentaModel	= new Cuenta_model();
		$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );

		$saldoObj = $cuentaModel->getSaldoPersona( $movimientoObj->cuentaId, $personaId );
		
		// Si el movimiento ya estaba rubrado entonces vuelvo el saldo para atrás.
		if ( $movimientoObj->persona_id )
		{
			$saldoExObj = $cuentaModel->getSaldoPersona( $movimientoObj->cuentaId, $movimientoObj->persona_id );
			
			// El movimiento pero revertido.
			$saldoEx = $saldoExObj->saldo - $movimientoObj->credito + $movimientoObj->debito;
			
			if ( !$cuentaModel->setSaldoPersona( $saldoExObj->id, $saldoEx ) )
			{
				return false;
			}
			
			$this->sumSaldoDesdeMovimiento( $movimientoId, $movimientoObj->persona_id, - $movimientoObj->credito + $movimientoObj->debito );
		}

		$saldoObj = $cuentaModel->getSaldoPersona( $movimientoObj->cuentaId, $personaId );
		$saldo = $saldoObj->saldo + $movimientoObj->credito - $movimientoObj->debito;


		if ( $cuentaModel->setSaldoPersona( $saldoObj->id, $saldo ) )
		{
			// Update de movimiento_cuentas
			$data = array(
				'persona_id'							=> $personaId,
				'rubro_id'								=> $rubroId,
			//	'saldo_cta' . $movimientoObj->cuentaId	=> "saldo_cta" . $movimientoObj->cuentaId . "+" . $movimientoObj->credito - $movimientoObj->debito
			);

			$this->db->where('id', $movimientoId);

			$return = $this->db->update('movimientos_cuentas', $data);
			
			$this->sumSaldoDesdeMovimiento( $movimientoId, $personaId, $movimientoObj->credito - $movimientoObj->debito );
			
			return $return;
		}
		
		return false;
	}

	public function sumSaldoDesdeMovimiento( $movimientoId, $personaId, $aSumar )
	{
		$cuentaModel	= new Cuenta_model();
		$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );

		$this->db->set('saldo_cta' . $personaId, "saldo_cta" . $personaId . " +" . $aSumar, FALSE);
		
		//'saldo_cta' . $movimientoObj->cuentaId	=> "saldo_cta" . $movimientoObj->cuentaId . "+" . $movimientoObj->credito - $movimientoObj->debito

		$this->db->where('id >=' . $movimientoId);
		$this->db->where('cuentaId', $movimientoObj->cuentaId );

		$return = $this->db->update('movimientos_cuentas');
		
		//print_r($this->db->last_query());
		
		return $return;
	}
	
	public function getTotalSinRubrar( $cuentaId )
	{
		$this->db->select('SUM(credito) as total_credito, SUM(debito) as total_debito, SUM(credito) - SUM(debito) as total');
	
		$this->db->from('movimientos_cuentas');
		
		$this->db->where('status = ' . 1);
		$this->db->where('cuentaId = ' . $cuentaId);
		$this->db->where('persona_id', NULL);
		$this->db->where('rubro_id', NULL);

		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0];
	}
	
	public function rubradoAutomatico( $concepto )
	{
		
		$concepto = substr( $concepto , 0 , 12 );
		
		if ( $concepto == 'REDIVA 19210' )
		{
			$returnArray = array(
								"persona_id"	=> 3,
								"rubro_id"		=> 12
								);
								
			return $returnArray;
		}
		
		return false;
	}
}