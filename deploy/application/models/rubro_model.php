<?php
class rubro_model extends MY_Model {
	
	public $cuentasArray;
	
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
	
	public function getRubros( $personaId=false )
	{
		$this->db->select('*');

		$this->db->from('rubro_cuenta');
		
		if ( $personaId )
		{
			$this->db->where( 'rubro_persona_id', $personaId );
		}
		
		// If
		$this->db->where('status = ' . 1);

		// Order
		$this->db->order_by('nombre', 'ASC');
		
		//$this->db->group_by('rubro_persona_id');

		$query = $this->db->get();
		
		return $query->result();
	}

	public function getRubro( $rubroId )
	{
		$this->db->select('*');
	
		$this->db->from('rubro_cuenta');

		
		// If
		$this->db->where('id = ' . $rubroId );


		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		$result = $query->result();
		
		return ( count( $result ) ) ? $result[0] : false;
	}


	public function getRubrosGrouped()
	{
		$rubrosGrouped = array();
		
		foreach ( $this->getRubros() as $rubroObj )
		{
			$rubrosGrouped[$rubroObj->rubro_persona_id][$rubroObj->id]	= $rubroObj;
		}
		
		return $rubrosGrouped;
	}	


	public function getPersona( $filter=false )
	{

		if ( $filter )
		{
			$this->setSessionFiltros( 'id' );
		}

		$this->db->select('*');
	
		$this->db->from('rubro_persona');
		
		$this->db->where('status = ' . 1);
		
		$this->db->order_by('nombre', 'ASC');

		$query = $this->db->get();
		
		//echo $this->db->last_query() . ";----------------------------\n";
		
		return $query->result();
	}

	public function getUnaPersona( $personaId=false, $personaUniqueName=false )
	{
		$this->db->select('*');
	
		$this->db->from('rubro_persona');
		
		if ( $personaId )				$this->db->where('id = ' . $personaId);
		if ( $personaUniqueName )		$this->db->where("unique_name =  '" . $personaUniqueName . "'" );
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		$result = $query->result();
		
		if ( isset($result[0]) )		return $result[0];

		return false;
	}
	
	public function setRubrado( $movimientoId, $personaId, $rubroId, $concepto=false )
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
		//

		$saldoObj = $cuentaModel->getSaldoPersona( $movimientoObj->cuentaId, $personaId );
		$saldo = $saldoObj->saldo + $movimientoObj->credito - $movimientoObj->debito;


		if ( $cuentaModel->setSaldoPersona( $saldoObj->id, $saldo ) )
		{
			// Update de movimiento_cuentas
			$data = array(
				'persona_id'							=> $personaId,
				'rubro_id'								=> $rubroId,
			);
			
			if ( $concepto )
			{
				$data['concepto']	= $concepto;
			}

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
		
		$personaObj = $this->getUnaPersona( $personaId );
		
		if ( $personaObj->status != 0 )
		{
			$movimientoObj = $cuentaModel->getMovimiento( $movimientoId );
	
			$this->db->set('saldo_cta' . $personaId, "saldo_cta" . $personaId . " +" . $aSumar, FALSE);
	
			$this->db->where('id >=' . $movimientoId);
			$this->db->where('cuentaId', $movimientoObj->cuentaId );
	
			$return = $this->db->update('movimientos_cuentas');
			
			//echo $this->db->last_query() . ";\n";
			
			return $return;
		}
		
		return true;
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

	public function setSessionFiltros( $columnName='persona_id' )
	{
		$where = "";

		//////////////
		//  Rubros  //
		//////////////
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
	
	public function getTotalesPorRubro( $cuentaId )
	{
		$this->setSessionFiltros();

		$this->db->select('rubro_id, persona_id, SUM(credito) - SUM(debito) as total, rubro_cuenta.nombre as nombre, rubro_persona.nombre as persona_nombre, color_dark, color_light');

		$this->db->join('rubro_cuenta',		'rubro_cuenta.id = movimientos_cuentas.rubro_id', 'left');
		$this->db->join('rubro_persona',	'movimientos_cuentas.persona_id = rubro_persona.id', 'left');
	
		$this->db->from('movimientos_cuentas');

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

		$this->db->group_by('rubro_id');
		
		$this->db->order_by('persona_id', 'ASC');
		$this->db->order_by('total', 'ASC');

		$query = $this->db->get();

		//echo $this->db->last_query() . ";\n";
		
		$result = $query->result();
		
		return $result;
	}
	
	public function rubradoAutomatico( $concepto, $txt_otros=false )
	{
		$concepto = trim($concepto);
		
		if ( substr( $concepto , 0 , 12 ) == 'REDIVA 19210' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 12, "concepto" => $concepto );
		}

		if ( $concepto == 'TRASPASO A 41109 ILINK' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 8, "concepto" => $concepto . ' (British Schools)' );
		}

		if ( $concepto == 'TRASPASO A 3851304ILINK' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 11, "concepto" => $concepto . ' (Sandra)' );
		}

		if ( $concepto == 'PAGO FACTURAANTEL 262900' || $concepto == 'PAGO FACTURAIMMT05085591' || $concepto == 'PAGO FACTURAMVGAS 138601' || $concepto == 'PAGO FACTURAUTE 795716' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 20, "concepto" => $concepto );
		}

		if ( $concepto == 'DEB. VARIOS VISA' || $concepto == 'DEB. VARIOS VISA-ILINK' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 15, "concepto" => $concepto );
		}

		if ( $concepto == 'PAGO FACTURABPS' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 10, "concepto" => $concepto );
		}

		if ( $concepto == 'PAGO FACTURABPS' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 10, "concepto" => $concepto );
		}

		if ( $concepto == 'TRASPASO A 7954 ILINK' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 8, "concepto" => $concepto . ' (Popurrí)' );
		}

		if ( $concepto == 'TRASPASO A 3429076ILINK' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 20, "concepto" => $concepto . " (Gastos comunes Casonas)" );
		}

		if ( $concepto == 'TRASPASO A 6336322ILINK' )
		{
			return array(	"persona_id"	=> 3,	"rubro_id"		=> 4, "concepto" => $concepto . " (Dogclub)" );
		}

		if ( $concepto == 'DEP 24 HORAS 008859062' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 23, "concepto" => $concepto . " (Devoto San Quintín)" );
		}

		if ( $concepto == 'RECIBO DE PAGO' && $txt_otros == '...' )
		{
			return array(	"persona_id"	=> 4,	"rubro_id"		=> 15, "concepto" => $concepto );
		}
		
		
		return false;
		
		/**
			TELEPEAJE - De Viaje

		*/
	}

	
	public function getTotalesEntreFechas( $fecha_start, $fecha_end, $rubroId=false )
	{
		$this->db->select('rubro_cuenta.nombre as nombre, movimientos_cuentas.rubro_id as rubro_id, SUM( (debito * tipo_cambio) ) as total_debito, SUM( (credito * tipo_cambio) ) as total_credito, SUM( (credito * tipo_cambio) ) - SUM( (debito * tipo_cambio) ) as total, movimientos_cuentas.persona_id as persona_id, rubro_persona.color_light, rubro_persona.color_dark');
	
		$this->db->from('movimientos_cuentas');
		
		$this->db->join('rubro_cuenta',		'rubro_cuenta.id = movimientos_cuentas.rubro_id',		'left');
		$this->db->join('rubro_persona',	'rubro_cuenta.rubro_persona_id = rubro_persona.id',		'left');

		if ( count($this->cuentasArray) > 1 )
		{
			$this->setSessionFiltros();
			
			$where = "";

			foreach( $this->cuentasArray as $cuentaIdParaWhere )
			{
				$where .= 'cuentaId = ' . $cuentaIdParaWhere . " OR ";
			}
			
			$where = substr( $where, 0, -4 );
			
			$this->db->where("(" . $where . ")");
		}
		elseif ( $this->cuentasArray )
		{
			$this->setSessionFiltros();

			$this->db->where('cuentaId = ' . $this->cuentasArray[0] );
		}
		else
		{
			$this->db->where('rubro_id = ' . $rubroId );
		}
		
		$this->db->where("fecha >= '" . $fecha_start . "'" );
		$this->db->where("fecha <= '" . $fecha_end . "'" );

		$this->db->group_by('rubro_id');

		$query = $this->db->get();

		//echo $this->db->last_query() . ";\n";
		//die;
		
		$result = $query->result();
		
		return $result;
	}
}