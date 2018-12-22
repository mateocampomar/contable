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
		
		$this->db->insert('movimientos_cuentas', $data);
		
		return $this->db->insert_id();
	}
	
	public function getMovimientos( $cuentaId )
	{
		$this->db->select('*');
	
		$this->db->from('movimientos_cuentas');
		
		$this->db->where('status = ' . 1);
		$this->db->where('cuentaId = ' . $cuentaId );
		
		$this->db->order_by('id', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}
}