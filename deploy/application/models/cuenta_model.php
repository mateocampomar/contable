<?php
class cuenta_model extends MY_Model {
	
	public function listCuentas()
	{
		$this->db->select('*');
	
		$this->db->from('cuentas');
		
		$this->db->join('moneda', 'cuentas.moneda = moneda.moneda');
		
		$this->db->where('status = ' . 1);
		
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

	public function ingresarMovimiento( $cuentaId, $fecha, $concepto, $credito, $debito, $saldo )
	{
		$data = array(
			'cuentaId'		=> $cuentaId,
			'fecha'			=> $fecha,
			'concepto'		=> $concepto,
			'credito'		=> $credito,
			'debito'		=> $debito,
			'saldo'			=> $saldo,
			'status'		=> 1
		);
		
		if ( $this->db->insert('movimientos_cuentas', $data) )
		{
			$insertId = $this->db->insert_id();
			
			if ( $this->actualizarSaldo( $cuentaId, $saldo ) )
			{	
				return $insertId;
			}
		}
		
		return false;
	}
	
	public function getMovimientos( $cuentaId )
	{
		$this->db->select('*, movimientos_cuentas.id as movimientos_cuentas_id');
	
		$this->db->from('movimientos_cuentas');

		$this->db->join('rubro_persona', 'rubro_persona.id = movimientos_cuentas.persona_id', 'left');
		$this->db->join('rubro_cuenta', 'rubro_cuenta.id = movimientos_cuentas.rubro_id', 'left');
		
		$this->db->where('movimientos_cuentas.status = ' . 1);
		$this->db->where('cuentaId = ' . $cuentaId );
		
		$this->db->order_by('movimientos_cuentas.id', 'ASC');

		$query = $this->db->get();
		
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
		
		return $result[0];;
	}
	
	public function actualizarSaldo( $cuentaId, $saldo )
	{
		$data = array(
			'saldo'=> $saldo,
		);
		
		$this->db->where('id', $cuentaId);

		return $this->db->update('cuentas', $data);
	}
}